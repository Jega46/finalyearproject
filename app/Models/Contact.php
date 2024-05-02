<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'contact_name',
        'email',
        'mobile_number',
        'company_name',
        'gstin',
        'billing_address',
        'shipping_address',
    ];
}
