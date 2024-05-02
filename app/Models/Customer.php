<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    //fillable fields
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'mobile',
        'company_name',
        'gstin',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_pincode',
        'billing_country',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_pincode',
        'shipping_country',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
