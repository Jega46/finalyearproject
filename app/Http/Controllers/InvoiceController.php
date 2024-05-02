<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Tax;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class InvoiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Invoice/Index');
    }
}
