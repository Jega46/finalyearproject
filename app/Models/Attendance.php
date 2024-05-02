<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // public static function boot()
    // {
    //     parent::boot();
    //     static::deleting(function ($employee) {
    //         $employee->salarydetail->delete();
    //     });
    // }

    protected $fillable = [
        'employee_id',
        'attdate',
        'checkin',
        'checkout',
        'status',
        'notes'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
