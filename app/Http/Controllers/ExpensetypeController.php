<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Expense;
use App\Models\ExpenseType;

class ExpensetypeController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->where('company_id', auth()->user()->company_id);
        $expenses->when(request('s'), function ($q) {
            return $q->where(function ($query) {
                $query->where('name', 'like', "%" . trim(request('s')) . "%")->orWhere('expensetype', 'like', "%" . trim(request('s')) . "%");;
            });
        });
        $expenses->when(request('status'), function ($q) {
            return $q->where('status', request('status'));
        });
        $offset = (!empty(request('page'))) ? request('page') : 0;
        $expenses = $expenses->offset($offset)->paginate(20);
        return Inertia::render('Expensetype/Index', [
            'expenses' => $expenses,
            'pagination' => array('total' => $expenses->total(), 'current' => $expenses->currentPage(), 'pageSize' => $expenses->perPage())
        ]);
         return Inertia::render('Expensetype/Index', []);
    }
    public function create()
    {
        $expensetypes = ExpenseType::where('company_id', auth()->user()->company_id)->get();
        return Inertia::render('Expensetype/Create', ['expensetypes' => $expensetypes,]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'expensetype_id' => 'required',
            'amount' => 'required',
            'method' => 'required',
            'date' => 'required',
            'description' => 'nullable',
        ]);
        $data['date'] = (!empty($request->date)) ? date('Y-m-d', strtotime($request->date)) : null;
        //$data['user_id'] = auth()->user()->id;
        $data['company_id'] = auth()->user()->company_id;

        $expenseid = Expense::create($data)->id;
        $request->session()->flash('message', 'Expense created successfully!');
        return Redirect::route('expensetype.index');
    }
    public function edit(Expense $expensetype)
    {
        return Inertia::render('Expensetype/Edit', [
            'expensetype' => $expensetype
        ]);
    }
     public function update(Request $request, Expense $expensetype)
    {
        $data = $request->validate([
            'name' => 'required',
            'expensetype' => 'required',
            'amount' => 'required',
            'method' => 'required',
            'date' => 'required',
            'description' => 'nullable',
        ]);
        $data['date'] = (!empty($request->date)) ? date('Y-m-d', strtotime($request->date)) : null;
        //$data['user_id'] = auth()->user()->id;
        $data['company_id'] = auth()->user()->company_id;
        $expensetype->update($data);
        $request->session()->flash('message', 'Expense updated successfully!');
        return Redirect::route('expensetype.index');
    }
    public function destroy(Expense $expensetype, Request $request)
    {
        $expensetype->delete();
        $request->session()->flash('message', 'Expense deleted successfully!');
        return Redirect::route('expensetype.index');
    }

     public function update_expensetype(Request $request)
    {
        $expensetype = ExpenseType::with('expensetype')->get();
        $data = $request->validate([
            'expensetype' => 'required',
        ]);
        $expense = ExpenseType::create($data)->id;
        $request->session()->flash('message', 'Expensetype created successfully!');
        return Redirect::route('expensetype.create');
    }
}
