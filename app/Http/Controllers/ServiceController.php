<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class ServiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Service/Index', [
        ]);
    }
}
