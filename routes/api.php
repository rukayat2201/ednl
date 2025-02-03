<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/customers/create', [CustomerController::class, 'store']);
Route::put('customers/update/{customer_id}', [CustomerController::class, 'update']);
Route::get('/customers', [CustomerController::class, 'index']);
