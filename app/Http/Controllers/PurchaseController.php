<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Party;

class PurchaseController extends Controller
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
        // return Inertia::render('Purchase/Index', [
        //     // 'employees' => $employees,
        //     // 'pagination' => array('total' => $employees->total(), 'current' => $employees->currentPage(), 'pageSize' => $employees->perPage())
        // ]);
        return Inertia::render('Purchase/Index', []);
    }
   
   public function create()
    {
        return Inertia::render('Purchase/Create', []);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'partyname' => 'required',
            'mobile' => 'required',
            'who_r_they' => 'required',
            'gstin' => 'required',
            'flat_no' => 'required',
            'area_loc' => 'required',
            'pincode' => 'required',
            'city' => 'required',
            'state' => 'required',
            'same_ship' => 'required',
        ]);
        $data['company_id'] = auth()->user()->company_id;

        $party_id = Party::create($data)->id;
        $request->session()->flash('message', 'Party created successfully!');
        return Redirect::route('purchase.create');
    }
}
