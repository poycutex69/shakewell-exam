<?php

use App\Http\Controllers\Api\Auth\VoucherController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group( function () {
    Route::post('voucher', [VoucherController::class, 'store']);
    Route::get('vouchers', [VoucherController::class, 'index']);
    Route::get('voucher/{id}', [VoucherController::class, 'show']);
    Route::delete('voucher/{id}', [VoucherController::class, 'destroy']);
});

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/test', [RegisterController::class, 'test']);