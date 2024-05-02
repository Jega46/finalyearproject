<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class PurchaseorderController extends Controller
{
    public function index()
    {
        return Inertia::render('Purchaseorder/Index');
    }
}
