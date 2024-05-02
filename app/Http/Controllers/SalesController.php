<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::leftJoin('contacts', function ($join) {
            $join->on('sales.contact_id', '=', 'contacts.id');
        })->select('sales.*','contacts.contact_name as contact_name')->where('sales.company_id', auth()->user()->company_id);
        $sales->when(request('s'), function ($q) {
            return $q->where(function ($query) {
                $query->where('sale_name', 'like', "%" . trim(request('s')) . "%")->orWhere('mobile_number', 'like', "%" . trim(request('s')) . "%")->orWhere('company_name', 'like', "%" . trim(request('s')) . "%");
            });
        });
        $offset = (!empty(request('page'))) ? request('page') : 0;
        $sales = $sales->offset($offset)->paginate(20);
        return Inertia::render('Sales/Index', [
            'sales' => $sales,
            'pagination' => array('total' => $sales->total(), 'current' => $sales->currentPage(), 'pageSize' => $sales->perPage())
        ]);
    }
    public function create()
    {
        return Inertia::render('Sales/Create', []);
    }
    public function invoice()
    {
        return Inertia::render('Sales/Invoice', []);
    }
}
