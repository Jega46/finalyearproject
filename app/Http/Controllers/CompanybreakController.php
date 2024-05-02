<?php

namespace App\Http\Controllers;

use App\Models\Attendancehistory;
use Illuminate\Http\Request;
use App\Models\Companybreak;
use App\Models\Employee;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CompanybreakController extends Controller
{
    public function index()
    { 
        $companybreaks = Companybreak::latest()->where('company_id', auth()->user()->company_id);
        $companybreaks->when(request('s'), function ($q) {
            return $q->where(function ($query) {
                $query->where('name', 'like', "%" . trim(request('s')) . "%")->orWhere('minute', 'like', "%" . trim(request('s')) . "%");;
            });
        });
        $offset = (!empty(request('page'))) ? request('page') : 0;
        $companybreaks = $companybreaks->offset($offset)->paginate(20);
        return Inertia::render('Companybreaks/Index', [
            'companybreaks' => $companybreaks,
            'pagination' => array('total' => $companybreaks->total(), 'current' => $companybreaks->currentPage(), 'pageSize' => $companybreaks->perPage())
        ]);
    }
    public function create(Request $request)
    {
        $request->session()->flash('message', 'Companybreak created successfully!');
        return Inertia::render('Companybreaks/Create', []);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'minute' => 'required',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Companybreak::create($data)->id;
        $request->session()->flash('message', 'Companybreak created successfully!');
        return Redirect::route('companybreaks.index');
    }

    public function edit(Companybreak $companybreak)
    {
        return Inertia::render('Companybreaks/Edit', [
            'companybreak' => $companybreak
        ]);
    }

    public function update(Request $request, Companybreak $companybreak)
    {
        $data = $request->validate([
            'name' => 'required',
            'minute' => 'required',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        $companybreak->update($data);
        $request->session()->flash('message', 'Companybreak updated successfully!');
        return Redirect::route('companybreaks.index');
    }

    public function destroy(Companybreak $companybreak, Request $request)
    {
        $attendance = Attendancehistory::where('breakid', $companybreak->id)->count();
        if ($attendance == 0) {
            $companybreak->delete();
            $request->session()->flash('message', 'Companybreak deleted successfully!');
            return Redirect::route('companybreaks.index');
        } else {
            $request->session()->flash('error', 'Companybreak synced with attendance. Cant Delete!');
            return Redirect::route('companybreaks.index');
        }
    }
}
