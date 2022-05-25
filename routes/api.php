<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\DashboardController;



Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

// employee route
Route::apiResource('/employee', EmployeeController::class);
// supplier route
Route::apiResource('/supplier', SupplierController::class);

// category route
Route::apiResource('/category', CategoryController::class);
// product route
Route::apiResource('/product', ProductController::class);
// expense route
Route::apiResource('/expense', ExpenseController::class);

// salary route
Route::post('/salary/paid/{id}', [SalaryController::class, 'paid']);
Route::get('/salary', [SalaryController::class, 'allSalary']);
Route::get('/salary/view/{id}', [SalaryController::class, 'viewSalary']);
Route::get('/salary/edit/{id}', [SalaryController::class, 'editSalary']);
Route::post('/salary/update/{id}', [SalaryController::class, 'updateSalary']);

// stock route
Route::post('/stock/update/{id}', [ProductController::class, 'updateStock']);

// customer route
Route::apiResource('/customer', CustomerController::class);

// pos route
Route::get('/get/product/{id}', [PosController::class, 'getProduct']);

// add to cart route
Route::get('/addToCart/{id}', [CartController::class, 'addToCart']);
Route::get('/cart/product', [CartController::class, 'cartProduct']);
Route::get('/remove/Cart/{id}', [CartController::class, 'removeCart']);
Route::get('/increment/{id}', [CartController::class, 'increment']);
Route::get('/decrement/{id}', [CartController::class, 'decrement']);
// vat route
Route::get('/vat', [CartController::class, 'vat']);
Route::post('/orderDone', [PosController::class, 'orderDone']);

// setting route
Route::apiResource('/setting', SettingController::class);
// order route
Route::get('/order', [OrderController::class, 'todayOrder']);
Route::get('/allorder/{id}', [OrderController::class, 'allOrder']);
Route::get('/order/details/{id}', [OrderController::class, 'orderDetails']);
Route::post('/search', [OrderController::class, 'searchOrder']);

//dashboard
Route::get('/today/sell', [DashboardController::class, 'todaySell']);
Route::get('/income', [DashboardController::class, 'todayIncome']);
Route::get('/today/due', [DashboardController::class, 'todayDue']);
Route::get('/today/expense', [DashboardController::class, 'todayExpense']);
Route::get('/today/stockout', [DashboardController::class, 'todayStockout']);