<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerRegisterController;
use App\Http\Controllers\ClientRegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;

// Landing page
Route::get('/', function () {
    return view('landing-page');
});

// ======================
// AUTH
// ======================
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login.form');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// ======================
// ADMIN AREA
// ======================
Route::get('/admindashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

Route::get('/admin/pending-accounts', [DashboardController::class, 'pendingAccounts'])
    ->name('admin.pending.accounts');

Route::post('/admin/pending-accounts/{id}/approve', [DashboardController::class, 'approve'])
    ->name('admin.pending.approve');

Route::post('/admin/pending-accounts/{id}/reject', [DashboardController::class, 'reject'])
    ->name('admin.pending.reject');

Route::get('/admin/trades', [DashboardController::class, 'trades'])
    ->name('admin.trades');

Route::post('/admin/trades/store', [DashboardController::class, 'storeTrade'])->name('admin.trades.store');

Route::post('/admin/trades/{id}/update', [DashboardController::class, 'updateTrade'])->name('admin.trades.update');


// ======================
// WORKER DASHBOARD
// ======================
Route::get('/worker/dashboard', function () {
    return "Worker Dashboard";
})->name('worker.dashboard');

// ======================
// CLIENT DASHBOARD
// ======================
Route::get('/client/dashboard', function () {
    return "Client Dashboard";
})->name('client.dashboard');

// ======================
// CLIENT REGISTRATION
// ======================
Route::get('/create-account-user', [ClientRegisterController::class, 'showForm'])
    ->name('client.register.form');

Route::post('/create-account-user', [ClientRegisterController::class, 'register'])
    ->name('client.register.submit');

// ======================
// WORKER REGISTRATION
// ======================
Route::get('/create-account-worker', [WorkerRegisterController::class, 'create'])
    ->name('worker.register.form');

Route::post('/worker/register', [WorkerRegisterController::class, 'store'])
    ->name('worker.register');
