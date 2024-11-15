<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OrderController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::resource('products', App\Http\Controllers\ProductController::class);
Route::resource('departments', App\Http\Controllers\DepartmentController::class);
Route::resource('clients', App\Http\Controllers\ClientController::class);
Route::resource('employees', App\Http\Controllers\EmployeeController::class);
Route::resource('interactions', App\Http\Controllers\InteractionController::class);
Route::resource('leads', App\Http\Controllers\LeadController::class);
Route::resource('orders', App\Http\Controllers\OrderController::class);
Route::resource('transactions', App\Http\Controllers\TransactionController::class);
Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');
Route::get('leads/{id}/convert', [LeadController::class, 'convertToClient'])->name('leads.convertToClient');
Route::get('leads/{id}/convert-to-client', [LeadController::class, 'convertToClient'])->name('leads.convertToClient');

Route::get('/get-product-price/{id}', function ($id) {
    $product = Product::find($id);
    if ($product) {
        return response()->json(['price' => $product->price]);
    }
    return response()->json(['error' => 'Product not found'], 404);
});

Route::get('/get-order-data', [OrderController::class, 'getOrderData']);
