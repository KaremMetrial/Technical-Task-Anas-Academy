<?php

use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\RegisterController as ApiRegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(ApiRegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ApiProductController::class);
});
