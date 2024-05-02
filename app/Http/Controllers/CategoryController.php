<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Employee;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->where('company_id', auth()->user()->company_id);
        $categories->when(request('s'), function ($q) {
            return $q->where(function ($query) {
                $query->where('name', 'like', "%" . trim(request('s')) . "%")->orWhere('description', 'like', "%" . trim(request('s')) . "%");;
            });
        });
        $offset = (!empty(request('page'))) ? request('page') : 0;
        $categories = $categories->offset($offset)->paginate(20);
        return Inertia::render('Categories/Index', [
            'categories' => $categories,
            'pagination' => array('total' => $categories->total(), 'current' => $categories->currentPage(), 'pageSize' => $categories->perPage())
        ]);
    }
    public function create(Request $request)
    {
        return Inertia::render('Categories/Create', []);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'branch_name' => 'required',
            'address' => 'required',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        Category::create($data)->id;
        $request->session()->flash('message', 'Category created successfully!');
        return Redirect::route('categories.index');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'branch_name' => 'required',
            'address' => 'required',
        ]);
        $data['company_id'] = auth()->user()->company_id;
        $category->update($data);
        $request->session()->flash('message', 'Category updated successfully!');
        return Redirect::route('categories.index');
    }

    public function destroy(Category $category, Request $request)
    {
        $items = Item::where('category_id', $category->id)->count();
        if ($items == 0) {
            $category->delete();
            $request->session()->flash('message', 'Category deleted successfully!');
            return Redirect::route('categories.index');
        } else {
            $request->session()->flash('message', 'Category deleted successfully!');
            return Redirect::route('categories.index');
        }
    }
}
