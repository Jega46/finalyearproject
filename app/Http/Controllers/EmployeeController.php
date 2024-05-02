<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Salarydetail;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\LatepenaltySetting;
use App\Models\Overtimesetting;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $employees = Employee::latest()->where('company_id', auth()->user()->company_id);
        $employees->when(request('s'), function ($q) {
            return $q->where(function ($query) {
                $query->where('name', 'like', "%" . trim(request('s')) . "%")->orWhere('email', 'like', "%" . trim(request('s')) . "%");;
            });
        });
        $employees->when(request('status'), function ($q) {
            return $q->where('status', request('status'));
        });
        $offset = (!empty(request('page'))) ? request('page') : 0;
        $limit = (!empty(request('pageSize'))) ? request('pageSize') : 20;
        $employees = $employees->offset($offset)->paginate($limit);

        return Inertia::render('Employees/Index', [
            'employees' => $employees,
            'pagination' => array('total' => $employees->total(), 'current' => $employees->currentPage(), 'pageSize' => $employees->perPage())
        ]);
    }
    public function create()
    {
        $branches = Branch::where('company_id', auth()->user()->company_id)->get();
        return Inertia::render('Employees/Create', ['branches' => $branches,]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'branch_id' => 'required',
            'mobile' => 'required',
            'designation' => 'required',
            'gender' => 'nullable',
            'email' => 'nullable|email',
            'doj' => 'nullable',
            'address' => 'nullable',
            'working_days' => 'array|nullable',
            'work_timing' => 'nullable',
            'bank_name' => 'nullable',
            'account_number' => 'nullable',
            'ifsc_code' => 'nullable',
            'accountholder_name' => 'nullable',
            'employeeid' => 'nullable',
            'dob' => 'nullable',
            'aadhar_number' => 'nullable',
            'uan_number' => 'nullable',
            'pan_number' => 'nullable',
            'pf_number' => 'nullable',
            'esi_number' => 'nullable',
        ]);
        $data['work_start_time'] = (!empty($request->work_timing)) ? date('H:i:s', strtotime($request->work_timing[0])) : null;
        $data['work_end_time'] = (!empty($request->work_timing)) ? date('H:i:s', strtotime($request->work_timing[1])) : null;
        $data['doj'] = (!empty($request->doj)) ? date('Y-m-d', strtotime($request->doj)) : null;
        $data['dob'] = (!empty($request->dob)) ? date('Y-m-d', strtotime($request->dob)) : null;
        //$data['user_id'] = auth()->user()->id;
        $data['company_id'] = auth()->user()->company_id;

        $employee_id = Employee::create($data)->id;
        $request->session()->flash('message', 'Employee created successfully!');
        return Redirect::route('employees.index');
    }

    public function edit(Employee $employee)
    {
        $branches = Branch::where('company_id', auth()->user()->company_id)->get();
        return Inertia::render('Employees/Edit', [
            'employee' => $employee,
            'branches' => $branches
        ]);
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name' => 'required',
            'branch_id' => 'required',
            'mobile' => 'required',
            'designation' => 'required',
            'gender' => 'nullable',
            'email' => 'nullable|email',
            'doj' => 'nullable',
            'address' => 'nullable',
            'working_days' => 'array|nullable',
            'work_timing' => 'nullable',
            'bank_name' => 'nullable',
            'account_number' => 'nullable',
            'ifsc_code' => 'nullable',
            'accountholder_name' => 'nullable',
            'employeeid' => 'nullable',
            'dob' => 'nullable',
            'aadhar_number' => 'nullable',
            'uan_number' => 'nullable',
            'pan_number' => 'nullable',
            'pf_number' => 'nullable',
            'esi_number' => 'nullable',
        ]);
        $data['work_start_time'] = (!empty($request->work_timing)) ? date('H:i:s', strtotime($request->work_timing[0])) : null;
        $data['work_end_time'] = (!empty($request->work_timing)) ? date('H:i:s', strtotime($request->work_timing[1])) : null;
        $data['doj'] = (!empty($request->doj)) ? date('Y-m-d', strtotime($request->doj)) : null;
        $data['dob'] = (!empty($request->dob)) ? date('Y-m-d', strtotime($request->dob)) : null;
        //$data['user_id'] = auth()->user()->id;
        $data['company_id'] = auth()->user()->company_id;
        $employee->update($data);
        $request->session()->flash('message', 'Employee updated successfully!');
        return Redirect::route('employees.index');
    }

    public function salarydetails($employee_id)
    {
        $employee = Employee::with('salarydetail', 'otsettings','latepenalty_setting')->find($employee_id);
        return Inertia::render('Employees/SalaryDetails', ['employee' => $employee]);
    }

    public function destroy(Employee $employee, Request $request)
    {
        $employee->delete();
        $request->session()->flash('message', 'Employee deleted successfully!');
        return Redirect::route('employees.index');
    }

    public function update_salary_info(Request $request, $employee_id)
    {
        $salarydetail = Salarydetail::where('employee_id', $employee_id)->first();
        $data = $request->validate([
            'salary_type' => 'required',
            'salary_amount' => 'required',
            'allowances' => 'sometimes|nullable',
            'pf_detail' => 'sometimes|nullable',
            'pf_amount' => 'sometimes|nullable',
            'esi_detail' => 'sometimes|nullable',
            'esi_amount' => 'sometimes|nullable',
            'ctc' => 'sometimes|nullable'
        ]);
        $data['employee_id'] = $employee_id;
        if (empty($salarydetail)) {
            Salarydetail::create($data)->id;
        } else {
            Salarydetail::where('employee_id', $employee_id)->update($data);
        }
        $request->session()->flash('message', 'Salary info updated!');
        return Redirect::route('employees.index');
    }

    public function update_ot_info(Request $request, $employee_id)
    {
        $data = $request->validate([
            'weekoff_pay' => 'required',
            'publicholiday_pay' => 'required',
            'extra_hours_pay' => 'required',
            'grace_period' => 'required',
        ]);
        $data['employee_id'] = $employee_id;
        Overtimesetting::updateOrCreate($data, ['employee_id' => $employee_id]);
        $request->session()->flash('message', 'OT info updated!');
        return Redirect::route('employees.update_salary_info', $employee_id);
    }
    public function update_latepenalty_info(Request $request, $employee_id)
    {
        $data = $request->validate([
            'allowed_days' => 'required',
            'deduction_type' => 'required',
            'deduction_rate' => 'required',
            'grace_period' => 'required',
        ]);
        $data['employee_id'] = $employee_id;
        LatepenaltySetting::updateOrCreate($data, ['employee_id' => $employee_id]);
        $request->session()->flash('message', 'Late Penalty info updated!');
        return Redirect::route('employees.update_salary_info', $employee_id);
    }
    
    public function attendance($employee_id)
    {
        $employee = Employee::with('salarydetail')->find($employee_id);
        $month = date('m');
        $year = date('Y');
        $attendance = Attendance::where('employee_id', $employee_id)->whereMonth('attdate', '=', $month)->whereYear('attdate', '=', $year)->get();
        $attdata = array();
        $type = array(
            'Present' => 'primary',
            'Absent' => 'danger',
            'Paid Leave' => 'default',
            'Unpaid Leave' => 'dashed'
        );
        foreach ($attendance as $att) {

            $attdata[date('d', strtotime($att->attdate))] = array(
                'status' => $att->status,
                'type' => $type[$att->status],
                'checkin' => $att->checkin,
                'checkout' => $att->checkout,
                'notes' => $att->notes
            );
        }
        return Inertia::render('Employees/Attendance', [
            'employee' => $employee,
            'attdata' => $attdata,
            'today' => date('d'),
            'month' => date('m')
        ]);
    }
}
