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

class AttendancecopyController extends Controller
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
                    'attdate' => date('d-m-Y', strtotime($attendance->attdate)),
                    'status' => $attendance->status,
                    'notes' => $attendance->notes,
                );

                $history = Attendancehistory::where('employee_id', $employee->id)->where('attdate', $date)->get();
                foreach ($history as $his) {
                    $attdata['history'][] = array(
                        'id' => $his->id,
                        'checkin' => date('H:i:s', strtotime($his->checkin)),
                        'checkout' => (!empty($his->checkout)) ? date('H:i:s', strtotime($his->checkout)) : null,
                    );
                }
                if ($history[array_key_last($history->toArray())]->checkout != NULL) {
                    $attdata['history'][] = array(
                        'id' => NULL,
                        'checkin' => '',
                        'checkout' => '',
                    );
                }
                // -- Overtime Calculation -- //
                $overtime_hrs = '';
                $actual_work_hours = (strtotime($employee->work_end_time) - strtotime($employee->work_start_time)) / 3600;
                $emp_worked_hrs = 0;
                foreach ($history as $his) {
                    if (!empty($his->checkin) && !empty($his->checkout)) {
                        $emp_worked_hrs += (strtotime($his->checkout) - strtotime($his->checkin)) / 3600;
                    }
                }
                $overtime_minutes = ($emp_worked_hrs - $actual_work_hours) > 0 ? ($emp_worked_hrs - $actual_work_hours) * 60 : 0;
                $overtime_hrs = floor($overtime_minutes / 60) . ':' . ($overtime_minutes -   floor($overtime_minutes / 60) * 60);
                $attdata['overtime'] = (!empty($attendance->overtime)) ? $attendance->overtime : $overtime_hrs;
                // -- Overtime Calculation End -- //
                // -- if late check -- //
                $late = false;
                $late_settings = LatepenaltySetting::where('employee_id', $employee->id)->first();
                $min = (!empty($late_settings) && $late_settings->grace_period != '') ? $late_settings->grace_period : 0;
                if (strtotime($attendance->checkin . " -" . $min . " minutes",) > strtotime($employee->work_start_time)) {
                    $late = true;
                }
                $attdata['late'] = (!empty($attendance->late != NULL)) ? (($attendance->late == '1') ? true : false) : $late;
                // -- if late check end -- //
            } else {
                $attdata = array(
                    'employee_id' => $employee->id,
                    'name' => $employee->name,
                    'attdate' => $date,
                    'status' => in_array(date("l", strtotime($date)), ["Saturday", "Sunday"]) ? 'Week Off' : 'Absent',
                    'notes' => '',
                    'overtime' => '',
                    'late' => false,
                    'history' => [
                        array(
                            'id' => NULL,
                            'checkin' => '',
                            'checkout' => '',
                        )
                    ]
                );
            }
            $data[] = $attdata;
        }
        $branches = Branch::where('company_id', auth()->user()->company_id)->get();
        return Inertia::render('Attendance/Index', [
            'date' => $date,
            'employees' => $data,
            'branches' => $branches,
            'pagination' => array('total' => $employees->total(), 'current' => $employees->currentPage(), 'pageSize' => $employees->perPage())
        ]);
    }

    public function clockin(Request $request)
    {
        $history = $request->history;
        foreach ($history as $his) {
            if ($his['checkin'] == '' && $his['checkout'] == '' && $his['id'] == '') {
                continue;
            }
            if ($his['checkin'] == '' && $his['checkout'] == '' && $his['id'] != '') {
                Attendancehistory::where('id', $his['id'])->delete();
            }
            if ($his['checkin'] == '' && $his['checkout'] != '') {
                $request->session()->flash('error', 'Please add checkin value!');
                return response(array('code' => 400));
            }
            if (!empty($his['checkout']) && $his['checkin'] >= $his['checkout']) {
                $request->session()->flash('error', 'Checkin time should be before checkout time!');
                return response(array('code' => 400));
            }
            $data = array(
                'employee_id' => $request->employee_id,
                'attdate' => date('Y-m-d', strtotime($request->date)),
                'checkin' => date('H:i:s', strtotime($his['checkin'])),
                'checkout' => (!empty($his['checkout']) && $his['checkout'] != 'null') ? date('H:i:s', strtotime($his['checkout'])) : null,
            );
            if (empty($his['id'])) {
                Attendancehistory::create($data);
            } else {
                Attendancehistory::where('id', $his['id'])->update($data);
            }
        }
        $data = [
            'attdate' => date('Y-m-d', strtotime($request->date)),
            'employee_id' => $request->employee_id,
            'checkin' => $history[0]['checkin'],
            'checkout' => end($history)['checkout'],
            'notes' => (!empty($request->notes)) ? $request->notes : NULL,
            'status' => 'Present'
        ];
        Attendance::updateOrCreate(['employee_id' => $request->employee_id, 'attdate' => date('Y-m-d', strtotime($request->date))], $data);
        return response(array('code' => 200));
    }

    public function clockout(Request $request)
    {
        $history = $request->history;
        foreach ($history as $his) {
            if ($his['checkin'] == '' && $his['checkout'] == '' && $his['id'] == '') {
                continue;
            }
            if ($his['checkin'] == '' && $his['checkout'] == '' && $his['id'] != '') {
                Attendancehistory::where('id', $his['id'])->delete();
            }
            if ($his['checkin'] == '' && $his['checkout'] != '') {
                $request->session()->flash('error', 'Please add checkin value!');
                return response(array('code' => 400));
            }
            if (!empty($his['checkout']) && $his['checkin'] >= $his['checkout']) {
                $request->session()->flash('error', 'Checkin time should be before checkout time!');
                return response(array('code' => 400));
            }
            $data = array(
                'employee_id' => $request->employee_id,
                'attdate' => date('Y-m-d', strtotime($request->date)),
                'checkin' => date('H:i:s', strtotime($his['checkin'])),
                'checkout' => (!empty($his['checkout']) && $his['checkout'] != 'null') ? date('H:i:s', strtotime($his['checkout'])) : null,
            );
            if (empty($his['id'])) {
                Attendancehistory::create($data);
            } else {
                Attendancehistory::where('id', $his['id'])->update($data);
            }
        }
        $data = [
            'attdate' => date('Y-m-d', strtotime($request->date)),
            'employee_id' => $request->employee_id,
            'checkin' => $history[0]['checkin'],
            'checkout' => end($history)['checkout'],
            'notes' => (!empty($request->notes)) ? $request->notes : NULL,
            'status' => 'Present'
        ];
        Attendance::updateOrCreate(['employee_id' => $request->employee_id, 'attdate' => date('Y-m-d', strtotime($request->date))], $data);
        return response(array('code' => 200));
    }

    public function updateatt_statusnotes(Request $request)
    {
        $data = [
            'attdate' => date('Y-m-d', strtotime($request->date)),
            'employee_id' => $request->employee_id,
            'notes' => (!empty($request->notes)) ? $request->notes : NULL,
            'status' => $request->status
        ];
        Attendance::updateOrCreate(['employee_id' => $request->employee_id, 'attdate' => date('Y-m-d', strtotime($request->date))], $data);
        $request->session()->flash('error', 'Data Updated!');
        return Redirect::back();
    }
    public function update_overtime(Request $request)
    {
        if (Attendance::where('employee_id', $request->employee_id)->where('attdate', $request->date)->count()) {
            Attendance::where('employee_id', $request->employee_id)->where('attdate', $request->date)->update(['overtime' => $request->overtime]);
            $request->session()->flash('message', 'Data Updated!');
            return Redirect::back();
        } else {
            $request->session()->flash('error', 'Please add attendance first!');
            return Redirect::back();
        }
    }
    public function update_late(Request $request)
    {
        if (Attendance::where('employee_id', $request->employee_id)->where('attdate', $request->date)->count()) {
            Attendance::where('employee_id', $request->employee_id)->where('attdate', $request->date)->update(['late' => ($request->late) ? true : false]);
            $request->session()->flash('message', 'Data Updated!');
            return Redirect::back();
        } else {
            $request->session()->flash('error', 'Please add attendance first!');
            return Redirect::back();
        }
    }
    public function remove_attendance_history(Request $request, $id)
    {
        $attHistory = Attendancehistory::where('id', $id)->first();
        if (!empty($attHistory)) {
            $otherAttendanceHistory = Attendancehistory::where('employee_id', $attHistory->employee_id)->where('attdate', $attHistory->attdate)->where('id', '<>', $id)->get()->toArray();
            if (!empty($otherAttendanceHistory)) {
                Attendance::where('employee_id', $attHistory->employee_id)->where('attdate', $attHistory->attdate)->update(
                    [
                        'overtime' => null
                    ]
                );
            } else {
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

    public function update(Request $request)
    {

        foreach ($request->employees as $employee) {
            if (!empty($employee['checkin']) || !empty($employee['checkout'])) {
                $data = [
                    'attdate' => date('Y-m-d'),
                    'employee_id' => $employee['employee_id'],
                    'checkin' => (!empty($employee['checkin'])) ? date('H:i:s', strtotime($employee['checkin'])) : NULL,
                    'checkout' => (!empty($employee['checkout'])) ? date('H:i:s', strtotime($employee['checkout'])) : NULL,
                    'notes' => (!empty($employee['notes'])) ? $employee['notes'] : NULL,
                    'status' => (!empty($employee['status'])) ? $employee['status'] : 'Present'
                ];
                Attendance::updateOrCreate(['employee_id' => $employee['employee_id'], 'attdate' => date('Y-m-d')], $data);
            }
        }
        return response(array('code' => 200));
    }
}
