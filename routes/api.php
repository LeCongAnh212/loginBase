<?php

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [ClientController::class, 'register']);
Route::post('login', [ClientController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('info', [ClientController::class, 'info']);
});
