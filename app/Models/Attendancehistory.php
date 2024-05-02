<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendancehistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'attdate',
        'checkin',
        'checkout',
        'breakid',
        'branchid',
        'notes'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function break()
    {
        return $this->belongsTo(Companybreak::class, 'breakid', 'id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branchid', 'id');
    }
}
