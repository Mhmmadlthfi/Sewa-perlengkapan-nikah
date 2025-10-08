<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MobileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth:sanctum');

Route::get('/categories', [MobileController::class, 'categories'])->middleware('auth:sanctum');
Route::get('/products', [MobileController::class, 'products'])->middleware('auth:sanctum');

Route::post('/check-availability', [MobileController::class, 'checkAvailability'])->middleware('auth:sanctum');
Route::post('/rental-orders', [MobileController::class, 'orderStore'])->middleware('auth:sanctum');
Route::post('/orders/{orderId}/regenerate-snap', [MobileController::class, 'regenerateSnap'])->middleware('auth:sanctum');
Route::post('/orders/{orderId}/check-payment-status', [MobileController::class, 'checkPaymentStatus'])->middleware('auth:sanctum');


Route::get('/user-orders', [MobileController::class, 'getUserOrders'])->middleware('auth:sanctum');
Route::get('/user-orders/{orderId}', [MobileController::class, 'showOrderDetail'])->middleware('auth:sanctum');
Route::get('/user-orders/{orderId}/snap-token', [MobileController::class, 'getSnapToken'])->middleware('auth:sanctum');
