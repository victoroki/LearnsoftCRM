<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\InteractionController;
use App\Models\Product;
use App\Models\Client;
use App\Models\Lead;

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
Route::get('/getLeadData', [LeadController::class, 'getLeadData']);

// Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/data', [EmployeeController::class, 'getEmployees'])->name('employees.data');

Route::delete('/interactions/{lead}/delete-all', [InteractionController::class, 'deleteAll'])->name('interactions.deleteAll');

Route::get('/get-lead-employee/{leadId}', [OrderController::class, 'getEmployeeForLead']);


Route::resource('enquiries', App\Http\Controllers\EnquiryController::class);
Route::resource('employees', EmployeeController::class);

Route::get('/sync-reports', [ReportController::class, 'syncData']);

Route::resource('reports', App\Http\Controllers\ReportController::class);

Route::get('/get-product-price/{id}', [ProductController::class, 'getProductPrice']);

Route::get('/get-product-price/{id}', [OrderController::class, 'getProductPrice'])->name('getProductPrice');

Route::get('/leads/{lead_id}/products', [OrderController::class, 'getProductsByLead']);

Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');

Route::get('/api/{type}/{id}/products', function ($type, $id) {
    if ($type === 'client') {
        $client = Client::with('products')->find($id);
        if ($client) {
            $products = $client->products->pluck('product_name', 'id');
            return response()->json($products);
        }
    } elseif ($type === 'lead') {
        $lead = Lead::with('products')->find($id);
        if ($lead) {
            $products = $lead->products->pluck('product_name', 'id');
            return response()->json($products);
        }
    }
    return response()->json([], 404);
});

Route::get('/daily-reports/create', [DailyReportController::class, 'create'])->name('daily_reports.create');
Route::post('/daily-reports', [DailyReportController::class, 'store'])->name('daily_reports.store');
Route::get('/daily-reports/create/{employeeId}/{dayIndex?}', [DailyReportController::class, 'create'])->name('daily_reports.create');

// View the report for a specific day
Route::get('/daily-reports/view/{employeeId}/{dayIndex}', [DailyReportController::class, 'viewReport'])->name('daily_reports.view');





