<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Salarydetail;
use App\Models\Attendance;
use App\Models\Attendancehistory;
use App\Models\Branch;
use App\Models\LatepenaltySetting;
use DB;
use Excel;
use Illuminate\Support\Collection;

class AttendanceController extends Controller
{

    public function index()
    {
        $limit = (!empty(request('pageSize'))) ? request('pageSize') : 50;
        $offset = (!empty(request('page'))) ? request('page') : 0;
        $date = (!empty(request('date'))) ? date('Y-m-d', strtotime(request('date'))) : date('Y-m-d');
        $branch = (!empty(request('branch'))) ? request('branch') : '';
        $employees = Employee::latest()->where('company_id', auth()->user()->company_id);
        if (!empty($branch)) {
            $employees->whereJsonContains('branch_id', (int) $branch);
        }
        if (!empty(request('s'))) {
            $employees->where('name', 'like', '%' . request('s') . '%');
        }
        $employees = $employees->offset($offset)->paginate($limit);
        $data = [];
        foreach ($employees as $employee) {
            $attendance = Attendance::where('employee_id', $employee->id)->where('attdate', $date)->first();
            if (!empty($attendance)) {
                $attdata = array(
                    'employee_id' => $employee->id,
                    'name' => $employee->name,
                    'attdate' => $attendance->attdate,
                    'status' => $attendance->status,
                    'notes' => $attendance->notes,
                    'late' => $this->checklate($attendance->attdate, $employee->id)['islate']
                );
                $history = Attendancehistory::where('employee_id', $employee->id)->where('attdate', $date)->with('break', 'branch')->get();
                $attdata['history'] = (!empty($history)) ?  $history->toArray() : [];
            } else {
                $attdata = array(
                    'employee_id' => $employee->id,
                    'name' => $employee->name,
                    'attdate' => $date,
                    'status' => in_array(date("l", strtotime($date)), ["Saturday", "Sunday"]) ? 'Week Off' : 'Absent',
                    'notes' => '',
                    'overtime' => '',
                    'late' => false,
                    'history' => []
                );
            }
            $data[] = $attdata;
        }
        $branches = Branch::where('company_id', auth()->user()->company_id)->get();
        $breaks = DB::table('companybreaks')->get();
        return Inertia::render('Attendance/Index', [
            'date' => $date,
            'employees' => $data,
            'breaks' => $breaks,
            'branches' => $branches,
            'pagination' => array('total' => $employees->total(), 'current' => $employees->currentPage(), 'pageSize' => $employees->perPage())
        ]);
    }

    public function checklate($date, $employee_id)
    {
        $late = false;
        $attendance = Attendancehistory::where('employee_id', $employee_id)->where('attdate', $date)->with('employee')->orderBy('id', 'ASC')->first();
        if (!empty($attendance)) {
            $late_settings = LatepenaltySetting::where('employee_id', $attendance->employee->id)->first();
            $min = (!empty($late_settings) && $late_settings->grace_period != '') ? $late_settings->grace_period : 0;
            if (strtotime($attendance->checkin . " -" . $min . " minutes",) > strtotime($attendance->employee->work_start_time)) {
                $late = true;
            }
        }
        return array('islate' => $late);
    }

    public function clockin(Request $request)
    {
        $data = array(
            'employee_id' => $request->employee_id,
            'attdate' => date('Y-m-d', strtotime($request->date)),
            'checkin' => date('H:i:s'),
            'checkout' => null,
        );
        Attendancehistory::create($data);
        $data = [
            'attdate' => date('Y-m-d', strtotime($request->date)),
            'employee_id' => $request->employee_id,
            'notes' => (!empty($request->notes)) ? $request->notes : NULL,
            'status' => 'Present'
        ];
        Attendance::updateOrCreate(['employee_id' => $request->employee_id, 'attdate' => date('Y-m-d', strtotime($request->date))], $data);
    }

    public function clockout(Request $request)
    {
        $last_record = Attendancehistory::orderBy('id', 'desc')->where('employee_id', $request->employee_id)->first();
        $data = array(
            'checkout' => date('H:i:s'),
        );
        $last_record->update($data);
        if ($last_record->breakid != '') {
            $data = array(
                'employee_id' => $request->employee_id,
                'attdate' => date('Y-m-d', strtotime($request->date)),
                'checkin' => date('H:i:s'),
                'checkout' => null,
            );
            Attendancehistory::create($data);
        }
    }

    public function addBreak(Request $request)
    {
        $last_record = Attendancehistory::orderBy('id', 'desc')->where('employee_id', $request->employee_id)->first();
        $data = array(
            'checkout' => date('H:i:s'),
        );
        $last_record->update($data);

        $data = array(
            'employee_id' => $request->employee_id,
            'attdate' => date('Y-m-d', strtotime($request->date)),
            'checkin' => date('H:i:s'),
            'checkout' => null,
            'breakid' => $request->breakid
        );
        Attendancehistory::create($data);
    }

    public function addmultiplehistory(Request $request)
    {
        // $this->validate($request, [
        //     'checkin' => 'required|date_format:H:i:s',
        //     'checkout' => 'nullable|date_format:H:i:s|after:checkin',
        // ], ['checkout.after' => 'The checkout must be a time after checkin']);

        // print_r($request->history);
        // exit;
        foreach ($request->history as $his) {
            if (!empty($his['checkin'])) {
                if (empty($his['id'])) {
                    $history = new Attendancehistory;
                } else {
                    $history = Attendancehistory::find($his['id']);
                }
                $history->attdate = $request->attdate;
                $history->employee_id = $request->employee_id;
                $history->checkin = $his['checkin'];
                $history->checkout = $his['checkout'];
                $history->breakid = $his['breakid'];
                $history->branchid = $his['branchid'];
                $history->notes = $his['notes'];
                $history->save();
            }
        }
        if (Attendancehistory::where('employee_id', $request->employee_id)->where('attdate', $request->attdate)->count() > 0) {
            $data = [
                'attdate' => date('Y-m-d', strtotime($request->attdate)),
                'employee_id' => $request->employee_id,
                'status' => 'Present'
            ];
            Attendance::updateOrCreate(['employee_id' => $request->employee_id, 'attdate' => date('Y-m-d', strtotime($request->attdate))], $data);
        }
        $request->session()->flash('message', 'Data Updated!');
        return Redirect::back();
    }


    public function updatehistory(Request $request)
    {
        $this->validate($request, [
            'checkin' => 'required|date_format:H:i:s',
            'checkout' => 'nullable|date_format:H:i:s|after:checkin',
        ], ['checkout.after' => 'The checkout must be a time after checkin']);
        $history = Attendancehistory::where('id', $request->id)->first();
        $history->checkin = $request->checkin;
        $history->checkout = $request->checkout;
        $history->breakid = $request->breakid;
        $history->branchid = $request->branchid;
        $history->notes = $request->notes;
        $history->save();
        $request->session()->flash('message', 'Data Updated!');
        return Redirect::back();
    }

    public function deletehistory(Request $request, $id)
    {
        $attHistory = Attendancehistory::where('id', $id)->first();
        if (!empty($attHistory)) {
            $otherAttendanceHistory = Attendancehistory::where('employee_id', $attHistory->employee_id)->where('attdate', $attHistory->attdate)->where('id', '<>', $id)->get()->toArray();
            if (empty($otherAttendanceHistory)) {
                Attendance::where('employee_id', $attHistory->employee_id)->where('attdate', $attHistory->attdate)->delete();
            }
            $attHistory->delete();
            $request->session()->flash('message', 'Data Removed!');
            return Redirect::back();
        } else {
            $request->session()->flash('error', 'Error removing data!');
            return Redirect::back();
        }
    }

    public function summaryreport(Request $request)
    {
        $fromdate = date('Y-m-d',strtotime($request->fromdate));
        $todate = date('Y-m-d',strtotime($request->todate));
        $employees = Employee::where('company_id', auth()->user()->company_id)->get();
        $attendance_status = array('Present' => 'P', 'Attendance' => 'A', 'Leave' => 'L');
        $data = [];
        $header = ['Employee ID', 'Employee Name', 'Present', 'Absent', 'Leave'];
        $date = date('F Y',strtotime($fromdate)); //Current Month Year
        while (strtotime($date) <= strtotime(date('Y-m',strtotime($fromdate)) . '-' . date('t', strtotime($fromdate)))) {
            $day = date('M-d', strtotime($date));
            $header[$date] = $day;
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
        }
        $data[] = $header;
        foreach ($employees as $emp) {
            $attendance = Attendance::whereBetween('attdate', [$fromdate, $todate])->where('employee_id', $emp->id)->get();
            $presentdays = Attendance::whereBetween('attdate', [$fromdate, $todate])->where('employee_id', $emp->id)->where('status', 'Present')->count();
            $absentdays = Attendance::whereBetween('attdate', [$fromdate, $todate])->where('employee_id', $emp->id)->where('status', 'Absent')->count();
            $leavedays = Attendance::whereBetween('attdate', [$fromdate, $todate])->where('employee_id', $emp->id)->where('status', 'Leave')->count();
            $attendancehistory = Attendance::whereBetween('attdate', [$fromdate, $todate])->where('employee_id', $emp->id)->get();
            $attdata = array(
                'emp_id' => $emp->employeeid,
                'emp_name' => $emp->name,
                'present' => $presentdays,
                'absent' => $absentdays,
                'leavedays' => $leavedays
            );
            $dt = date('F Y',strtotime($fromdate)); //Current Month Year
            while (strtotime($dt) <= strtotime(date('Y-m',strtotime($fromdate)) . '-' . date('t', strtotime($fromdate)))) {
                $day = date('M-d', strtotime($dt));
                $att = Attendance::where('attdate', $dt)->where('employee_id', $emp->id)->first();
                $attdata[$dt] = (!empty($att)) ? $attendance_status[$att->status] : 'A';
                $dt = date("Y-m-d", strtotime("+1 day", strtotime($dt)));
            }
            $data[] = $attdata;
        }
        return (new Collection($data))->downloadExcel(
            'attendance-summaryreport.xlsx',
            $writerType = null,
            $headings = false
        );
    }
}
