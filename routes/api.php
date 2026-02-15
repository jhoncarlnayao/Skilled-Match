<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WorkerAuthController;
use App\Http\Controllers\WorkerRegisterController;
use App\Http\Controllers\TradeController;

Route::post('/worker/login', [WorkerAuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/worker/profile', function (Request $request) {
    return $request->user();
});

Route::get('/trades', [TradeController::class, 'index']);
Route::post('/worker/register', [WorkerRegisterController::class, 'apiRegister']);