<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/transfer', [TransferController::class, 'store'])->name('transfer.store');
    Route::get('/wallet', [WalletController::class, 'show']);

    Route::delete('/logout', [LoginController::class, 'destroy']);
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/register', [RegisterController::class, 'store'])->name('register');
