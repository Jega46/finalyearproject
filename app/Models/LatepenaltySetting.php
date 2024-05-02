<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatepenaltySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'allowed_days',
        'deduction_type',
        'deduction_rate',
        'grace_period'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
