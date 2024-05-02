<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    public $table = 'parties';
    
    protected $fillable = [
        'company_id',
        'partyname',
        'mobile',
        'who_r_they',
        'gstin',
        'flat_no',
        'area_loc',
        'pincode',
        'city',
        'state',
        'same_ship',
    ];
}
