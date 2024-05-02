<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($employee) {
            if ($employee->salarydetail) {
                $employee->salarydetail->delete();
            }
            if ($employee->otsettings) {
                $employee->otsettings->delete();
            }
            if ($employee->latepenalty_setting) {
                $employee->latepenalty_setting->delete();
            }
            if ($employee->attendancehistory) {
                foreach($employee->attendancehistory as $attendancehistory){
                    $attendancehistory->delete();
                }
            }
            if ($employee->attendance) {
                foreach($employee->attendance as $attendance){
                    $attendance->delete();
                }
            }
        });
    }

    protected $fillable = [
        'company_id',
        'name',
        'branch_id',
        'designation',
        'mobile',
        'gender',
        'email',
        'doj',
        'address',
        'working_days',
        'work_start_time',
        'work_end_time',
        'bank_name',
        'account_number',
        'ifsc_code',
        'accountholder_name',
        'employeeid',
        'dob',
        'aadhar_number',
        'uan_number',
        'pan_number',
        'pf_number',
        'esi_number',
    ];
    protected $casts = [
        'working_days' => 'array',
        'branch_id' => 'array'
    ];

    public function salarydetail()
    {
        return $this->hasOne(Salarydetail::class, 'employee_id', 'id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'employee_id', 'id');
    }

    public function attendancehistory()
    {
        return $this->hasMany(Attendancehistory::class, 'employee_id', 'id');
    }

    public function otsettings()
    {
        return $this->hasOne(Overtimesetting::class, 'employee_id', 'id');
    }
    public function latepenalty_setting()
    {
        return $this->hasOne(LatepenaltySetting::class, 'employee_id', 'id');
    }
}
