<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CreditnoteController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PurchaseorderController;
use App\Http\Controllers\BillsController;
use App\Http\Controllers\RawmaterialController;
use App\Http\Controllers\JoborderController;
use App\Http\Controllers\BillofmaterialController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/products', ProductController::class);
    Route::resource('/services', ServiceController::class);
    Route::resource('/customers', CustomerController::class);
    Route::resource('/quotes', QuoteController::class);
    Route::resource('/invoices', InvoiceController::class);
    Route::resource('/payments', PaymentController::class);
    Route::resource('/sales/creditnotes', CreditnoteController::class);
    Route::resource('/purchase/vendors', VendorController::class);
    Route::resource('/purchaseorders', PurchaseorderController::class);
    Route::resource('/bills', BillsController::class);
    Route::resource('/rawmaterials', RawmaterialController::class);
    Route::resource('/joborders', JoborderController::class);
    Route::resource('/billofmaterials', BillofmaterialController::class);
});


Route::resource('blogs', BlogController::class);

require __DIR__ . '/auth.php';
