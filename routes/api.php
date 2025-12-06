<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\OrderApiController;

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

Route::middleware('auth:sanctum')->group(function () {
    // Customer API endpoints
    Route::get('/customers', [CustomerApiController::class, 'index']);
    Route::get('/customers/{id}', [CustomerApiController::class, 'show']);
    Route::post('/customers', [CustomerApiController::class, 'store']);
    Route::put('/customers/{customer}', [CustomerApiController::class, 'update'])->middleware('admin');
    Route::delete('/customers/{customer}', [CustomerApiController::class, 'destroy'])->middleware('admin');

    // Order API endpoints
    Route::get('/orders', [OrderApiController::class, 'index']);
    Route::get('/orders/{id}', [OrderApiController::class, 'show']);
    Route::post('/orders', [OrderApiController::class, 'store']);
    Route::put('/orders/{order}', [OrderApiController::class, 'update'])->middleware('admin');
    Route::delete('/orders/{order}', [OrderApiController::class, 'destroy'])->middleware('admin');
});
