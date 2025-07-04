<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/referrals', [UserController::class, 'referrals']);
});


Route::post('/register', [RegisteredUserController::class, 'store']);

Route::post('/login', [RegisteredUserController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user()->load('vipLevel');
    return $user;
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/referrals', [UserController::class, 'myReferrals']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders/place', [OrderController::class, 'placeOrder']);
    Route::get('/orders/my', [OrderController::class, 'myOrders']);
});

Route::get('/orders/status', [OrderController::class, 'orderStatus']);
