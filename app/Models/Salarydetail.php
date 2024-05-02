<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salarydetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'salary_type',
        'salary_amount',
        'allowances',
        'pf_detail',
        'pf_amount',
        'esi_detail',
        'esi_amount',
        'ctc'
    ];
    protected $casts = [
        'allowances' => 'array',
    ];
}
