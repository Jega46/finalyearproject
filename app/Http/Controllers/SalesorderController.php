<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class SalesorderController extends Controller
{
    public function index()
    {
        return Inertia::render('Salesorder/Index', [
            'products' => [
                'data' => array(
                    array(
                        'id' => '1',
                        'order_no' => 'Iphone 12',
                        'customer_id' => 'Mobile Phones',
                        'customer_name' => 'Mobile Phones',
                        'date' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor',
                        'total_items' => '200',
                        'total_qty' => '200',
                        'net_amount' => '200',
                        'status' => '200',
                    ),
                    array(
                        'id' => '1',
                        'name' => 'Iphone 12',
                        'category' => 'Mobile Phones',
                        'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor',
                        'price' => '200',
                        'image' => 'https://assets.sangeethamobiles.com/product_img/8530/1667548639_LmA.jpg',
                        'track_inventory'=>'1',
                        'stock_status' => 'In Stock',
                        'in_stock_qty' => '100',
                    ),
                    array(
                        'id' => '1',
                        'name' => 'Iphone 12',
                        'category' => 'Mobile Phones',
                        'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor',
                        'price' => '200',
                        'image' => 'https://assets.sangeethamobiles.com/product_img/8530/1667548639_LmA.jpg',
                        'track_inventory'=>'1',
                        'stock_status' => 'In Stock',
                        'in_stock_qty' => '100',
                    ),
                    array(
                        'id' => '1',
                        'name' => 'Iphone 12',
                        'category' => 'Mobile Phones',
                        'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor',
                        'price' => '200',
                        'image' => 'https://assets.sangeethamobiles.com/product_img/8530/1667548639_LmA.jpg',
                        'track_inventory'=>'1',
                        'stock_status' => 'In Stock',
                        'in_stock_qty' => '100',
                    ),
                    array(
                        'id' => '1',
                        'name' => 'Iphone 12',
                        'category' => 'Mobile Phones',
                        'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor',
                        'price' => '200',
                        'image' => 'https://assets.sangeethamobiles.com/product_img/8530/1667548639_LmA.jpg',
                        'track_inventory'=>'1',
                        'stock_status' => 'In Stock',
                        'in_stock_qty' => '100',
                    ),
                    array(
                        'id' => '1',
                        'name' => 'Iphone 12',
                        'category' => 'Mobile Phones',
                        'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor',
                        'price' => '200',
                        'image' => 'https://assets.sangeethamobiles.com/product_img/8530/1667548639_LmA.jpg',
                        'track_inventory'=>'1',
                        'stock_status' => 'In Stock',
                        'in_stock_qty' => '100',
                    )
                )
            ],
            'pagination' => array('total' => 1, 'current' => 1, 'pageSize' => 10)
        ]);
    }
    public function create(Request $request)
    {
        return Inertia::render('Salesorder/Create', []);
    }

}
