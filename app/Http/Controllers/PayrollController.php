<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Salarydetail;
use App\Models\Attendance;
use App\Models\Attendancehistory;
use App\Models\Branch;
use App\Models\LatepenaltySetting;

class PayrollController extends Controller
{

    public function index()
    {
        $limit = (!empty(request('pageSize'))) ? request('pageSize') : 50;
        $offset = (!empty(request('page'))) ? request('page') : 0;
        $date = (!empty(request('date'))) ? date('Y-m-d', strtotime(request('date'))) : date('Y-m-d');
        $branch = (!empty(request('branch'))) ? request('branch') : '';
        $employees = Employee::latest()->where('company_id', auth()->user()->company_id);
        if (!empty($branch)) {
            $employees->whereJsonContains('branch_id', (int) $branch);
        }
        if (!empty(request('s'))) {
            $employees->where('name', 'like', '%' . request('s') . '%');
        }
        $employees = $employees->offset($offset)->paginate($limit);
        $branches = Branch::where('company_id', auth()->user()->company_id)->get();
        return Inertia::render('Payroll/Index', [
            'date' => $date,
            'employees' => $employees,
            'branches' => $branches,
            'pagination' => array('total' => $employees->total(), 'current' => $employees->currentPage(), 'pageSize' => $employees->perPage())
        ]);
    }
}
