<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CashbookController extends Controller
{
    public function index()
    {
        // $employees = Employee::latest()->where('company_id', auth()->user()->company_id);
        // $employees->when(request('s'), function ($q) {
        //     return $q->where(function ($query) {
        //         $query->where('name', 'like', "%" . trim(request('s')) . "%")->orWhere('email', 'like', "%" . trim(request('s')) . "%");;
        //     });
        // });
        // $employees->when(request('status'), function ($q) {
        //     return $q->where('status', request('status'));
        // });
        // $offset = (!empty(request('page'))) ? request('page') : 0;
        // $employees = $employees->offset($offset)->paginate(20);
        return Inertia::render('Cashbook/Index', []);
    }
    public function moneyin()
    {
        return Inertia::render('Cashbook/Moneyin', []);
    }
    public function moneyout()
    {
        return Inertia::render('Cashbook/Moneyout', []);
    }
}
