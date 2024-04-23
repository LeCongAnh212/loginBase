<?php

use App\Http\Controllers\User;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('info', [UserController::class, 'info']);
    Route::put('change-password', [UserController::class, 'changePassword']);
    Route::get('logout', [UserController::class, 'logout']);
});


