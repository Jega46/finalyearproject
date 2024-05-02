<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companybreak extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'minute'
    ];
}
