<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Employee;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class BranchController extends Controller
{
    public function index()
    { 
        $branches = Branch::latest()->where('company_id', auth()->user()->company_id);
        $branches->when(request('s'), function ($q) {
            return $q->where(function ($query) {
                $query->where('branch_name', 'like', "%" . trim(request('s')) . "%")->orWhere('address', 'like', "%" . trim(request('s')) . "%");;
            });
        });
        $offset = (!empty(request('page'))) ? request('page') : 0;
        $branches = $branches->offset($offset)->paginate(20);
        return Inertia::render('Branches/Index', [
            'branches' => $branches,
            'pagination' => array('total' => $branches->total(), 'current' => $branches->currentPage(), 'pageSize' => $branches->perPage())
        ]);
    }
    public function create(Request $request)
    {
        $request->session()->flash('message', 'Branch created successfully!');
        return Inertia::render('Branches/Create', []);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'branch_name' => 'required',
            'address' => 'required',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Branch::create($data)->id;
        $request->session()->flash('message', 'Branch created successfully!');
        return Redirect::route('branches.index');
    }

    public function edit(Branch $branch)
    {
        return Inertia::render('Branches/Edit', [
            'branch' => $branch
        ]);
    }

    public function update(Request $request, Branch $branch)
    {
        $data = $request->validate([
            'branch_name' => 'required',
            'address' => 'required',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        $branch->update($data);
        $request->session()->flash('message', 'Branch updated successfully!');
        return Redirect::route('branches.index');
    }

    public function destroy(Branch $branch, Request $request)
    {
        $employees = Employee::where('branch_id', $branch->id)->count();
        if ($employees == 0) {
            $branch->delete();
            $request->session()->flash('message', 'Branch deleted successfully!');
            return Redirect::route('branches.index');
        } else {
            $request->session()->flash('message', 'Branch deleted successfully!');
            return Redirect::route('branches.index');
        }
    }
}
