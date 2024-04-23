<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'user'], function () {
    Route::put('/update', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'delete']);
    Route::get('/get-all-user', [UserController::class, 'getAllUser']);
    Route::get('/info', [UserController::class, 'info']);
});
