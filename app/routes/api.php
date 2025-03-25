<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WarehouseApiController;
use App\Http\Controllers\Api\OrderApiController;

Route::get('/products', [WarehouseApiController::class, 'products']);
Route::get('/stock', [WarehouseApiController::class, 'stock']);
Route::get('/expiry-report', [WarehouseApiController::class, 'expiryReport']);
Route::get('/movements', [WarehouseApiController::class, 'movements']);

Route::post('/orders', [OrderApiController::class, 'create']);
Route::get('/orders/{id}', [OrderApiController::class, 'show']);