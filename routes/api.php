<?php

use App\Http\Controllers\CarsController;
use App\Http\Controllers\OrderController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('cars',CarsController::class);
Route::apiResource('orders',OrderController::class);
