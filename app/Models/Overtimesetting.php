<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtimesetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'weekoff_pay',
        'publicholiday_pay',
        'extra_hours_pay',
        'grace_period',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
