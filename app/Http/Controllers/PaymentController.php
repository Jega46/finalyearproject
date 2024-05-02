<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function index()
    {
        return Inertia::render('Payment/Index');
    }
}
