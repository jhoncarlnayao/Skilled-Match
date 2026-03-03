<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WorkerAuthController;
use App\Http\Controllers\WorkerRegisterController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\Api\JobController;

Route::post('/worker/login', [WorkerAuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/worker/profile', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/worker/my-jobs', [WorkerAuthController::class, 'myJobs']);

Route::get('/trades', [TradeController::class, 'index']);
Route::post('/worker/register', [WorkerRegisterController::class, 'apiRegister']);
Route::middleware('auth:sanctum')->get('/worker/jobs', [JobController::class, 'workerJobs']);

Route::post('/worker/jobs/{id}/accept', [JobController::class, 'acceptJob'])
    ->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->get('/worker/announcements', [JobController::class, 'index']);

    Route::middleware('auth:sanctum')->get('/worker/my-jobs', [JobController::class, 'myJobs']);