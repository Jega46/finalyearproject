<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'short_description',
        'image',
        'sku',
        'hsn',
        'unit',
        'purchase_price',
        'sales_price',
        'tax',
    ];
}

