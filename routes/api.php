<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotifiactionController;
use App\Http\Controllers\StockController;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('/orders', function (Request $request) {
//     return $request->user();
// });
Route::get('/products', [ProductController::class, 'index']);

Route::get('/products', [ProductController::class, 'show']);
Route::get('/products/{product}', [ProductController::class, 'select']);
Route::post('/products', [ProductController::class, 'store']);

Route::put('/products/{product_id}', [ProductController::class, 'update']);
Route::delete('/products/{product_id}', [ProductController::class, 'destroy']);



Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders', [OrderController::class, 'show']);
Route::get('/orders/{order}', [OrderController::class, 'select']);
Route::post('/orders', [OrderController::class, 'store']);
Route::put('/orders/{order_id}', [OrderController::class, 'update']);
Route::delete('/orders/{order_id}', [OrderController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users', [UserController::class, 'show']);
Route::get('/users/{user}', [UserController::class, 'select']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::get('/notifiactions', [NotifiactionController::class, 'index']);
Route::get('/notifiactions', [NotifiactionController::class, 'show']);
Route::get('/notifiactions/{notifiaction}', [NotifiactionController::class, 'select']);
Route::post('/notifiactions', [NotifiactionController::class, 'store']);
Route::put('/notifiactions/{notifiaction_id}', [NotifiactionController::class, 'update']);
Route::delete('/notifiactions/{notifiaction_id}', [NotifiactionController::class, 'destroy']);



Route::get('/stocks', [StockController::class, 'index']);
Route::get('/stocks', [StockController::class, 'show']);
Route::get('/stocks/{stock}', [StockController::class, 'select']);
Route::post('/stocks', [StockController::class, 'store']);
Route::put('/stocks/{stock_id}', [StockController::class, 'update']);
Route::delete('/stocks/{stock_id}', [StockController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users', [UserController::class, 'show']);
Route::get('/users/{user_id}', [UserController::class, 'select']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{user_id}', [UserController::class, 'update']);
Route::delete('/users/{user_id}', [UserController::class, 'destroy']);