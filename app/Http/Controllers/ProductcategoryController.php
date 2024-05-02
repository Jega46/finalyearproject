<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class ProductcategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Productcategory/Index', [
            'productcategories' => ['data' => array(
                array(
                    'id'=>'1',
                    'name' => 'Mobile',
                    'description' => 'Mobile Phones',
                    'no_of_products' => '299',
                ),
                array(
                    'id'=>'1',
                    'name' => 'Mobile',
                    'description' => 'Mobile Phones',
                    'no_of_products' => '299',
                ),
                array(
                    'id'=>'1',
                    'name' => 'Mobile',
                    'description' => 'Mobile Phones',
                    'no_of_products' => '299',
                ),
                array(
                    'id'=>'1',
                    'name' => 'Mobile',
                    'description' => 'Mobile Phones',
                    'no_of_products' => '299',
                ),
                array(
                    'id'=>'1',
                    'name' => 'Mobile',
                    'description' => 'Mobile Phones',
                    'no_of_products' => '299',
                ),
                array(
                    'id'=>'1',
                    'name' => 'Mobile',
                    'description' => 'Mobile Phones',
                    'no_of_products' => '299',
                )
            )],
            'pagination' => array('total' => 1, 'current' => 1, 'pageSize' => 10)
        ]);
    }
    public function create(Request $request)
    {
        return Inertia::render('Productcategory/Create', []);
    }
}
