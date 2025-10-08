<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');

Route::post('/', [LoginController::class, 'login'])->name('login-post')->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


// Category
Route::resource('/category', CategoryController::class)->middleware('auth');


// Product
Route::resource('/product', ProductController::class)->middleware('auth');

Route::post('/product/export', [ProductController::class, 'export'])->name('product.export')->middleware('auth');


// Order
Route::resource('/order', OrderController::class)->except(['edit', 'update'])->middleware('auth');

Route::post('/orders/export', [OrderController::class, 'export'])->name('order.export')->middleware('auth');

Route::patch('/order/{order}/status-update', [OrderController::class, 'statusUpdate'])
    ->name('order.status-update')
    ->middleware('auth');

Route::patch('/order/{order}/status-payment-update', [OrderController::class, 'statusPaymentUpdate'])
    ->name('order.status-payment-update')
    ->middleware('auth');

Route::patch('/order/{order}/delivery-fee-update', [OrderController::class, 'deliveryFeeUpdate'])
    ->name('order.delivery-fee-update')
    ->middleware('auth');


// Payment (Midtrans)
Route::post('/payment/callback', [PaymentController::class, 'handleCallback']);

Route::get('/payment/check-status/{order_code}', [PaymentController::class, 'checkStatus']);

Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');

// AJAX
Route::get('/ajax/products-table', [AjaxController::class, 'productsTable'])->name('ajax.products-table');

Route::get('/ajax/orders-table', [AjaxController::class, 'ordersTable'])->name('ajax.orders-table');

Route::get('/ajax/users-table', [AjaxController::class, 'usersTable'])->name('ajax.users-table');

Route::get('/ajax/product-search', [AjaxController::class, 'productSelect'])->name('ajax.produk-search');

Route::get('/ajax/customer-search', [AjaxController::class, 'userSelect'])->name('ajax.user-search');

Route::post('/check-availability', [AjaxController::class, 'checkAvailability'])->name('ajax.check-availability');


// User
Route::resource('/user', UserController::class)->middleware('auth');
