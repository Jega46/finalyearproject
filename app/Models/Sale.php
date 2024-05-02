<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'contact_id',
        'number',
        'sales_date',
        'subtotal',
        'discount_value',
        'discount_amount',
        'shipping_cost',
        'terms_condition',
        'notes',
        'order_status',
        'payment_method',
        'shipping_method'
    ];
}
