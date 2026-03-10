<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkerRegisterController;
use App\Http\Controllers\ClientRegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientJobController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GeminiController;


// ======================
// Landing page
// ======================
Route::get('/', function () {
    return view('landing-page');
});

Route::post('/test-post', function () {
    return 'POST received!';
});


// ======================
// AUTH LOGIN/LOGOUT
// ======================
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// ======================
// ADMIN AREA (Protected by auth middleware)
// ======================
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/pending-accounts', [DashboardController::class, 'pendingAccounts'])
        ->name('admin.pending.accounts');

    Route::get('/pending-accounts/{id}/approve', [DashboardController::class, 'approve'])
        ->name('admin.pending.approve');

    Route::get('/pending-accounts/{id}/reject', [DashboardController::class, 'reject'])
        ->name('admin.pending.reject');

    // Trades
    Route::get('/trades', [DashboardController::class, 'trades'])
        ->name('admin.trades');

    Route::post('/trades/store', [DashboardController::class, 'storeTrade'])
        ->name('admin.trades.store');

    Route::delete('/trades/{id}/delete', [DashboardController::class, 'deleteTrade'])
        ->name('admin.trades.delete');

    Route::post('/trades/{id}/update', [DashboardController::class, 'updateTrade'])
        ->name('admin.trades.update');

    // Client Accounts
    Route::get('/client-accounts', [DashboardController::class, 'getClientAccounts'])
        ->name('admin.client.accounts');

    //Update Worker Account
    Route::post('/worker-accounts/{id}/update',
    [DashboardController::class, 'updateWorker']
)->name('admin.worker.update');

    // Update Client Account
    Route::post('/client-accounts/{id}/update', 
    [DashboardController::class, 'updateClient']
)->name('admin.client.update');

    // Client Toggle Status
    Route::get('/client/toggle/{id}', 
        [DashboardController::class, 'toggleClientStatus']
    )->name('admin.client.toggle');

    // Announcements
    Route::post('/announcements/store', 
        [DashboardController::class, 'storeAnnouncement']
    )->name('admin.announcement.store');

    // Jobs
    Route::get('/jobs', [DashboardController::class, 'ShowJobs'])
        ->name('admin.jobs_list');

    // Deactivate/Activate Users
    Route::get('/user/{id}/deactivate', 
        [DashboardController::class, 'deactivate']
    )->name('admin.user.deactivate');

    // Deactivate/Activate Users
    Route::get('/user/{id}/activate', 
        [DashboardController::class, 'activate']
    )->name('admin.user.activate');

    //Update Job
    Route::put('/jobs/{job}', [DashboardController::class, 'updateJob'])->name('admin.jobs.update');

    //Delete Job
    Route::delete('/admin/jobs/{id}', [DashboardController::class, 'deleteJob'])
    ->name('admin.jobs.delete');

//     Route::get('/complaints', function () {
//     return view('admin.complaints');
// })->name('admin.complaints');

    Route::get('/complaints', [DashboardController::class, 'complaints'])
    ->name('admin.complaints');

Route::patch('/complaints/{id}', [DashboardController::class, 'updateComplaint'])
    ->name('admin.complaints.update');

Route::delete('/complaints/{id}', [DashboardController::class, 'deleteComplaint'])
    ->name('admin.complaints.delete');
});


// ======================
// WORKER DASHBOARD
// ======================
Route::get('/worker/dashboard', function () {
    return view('worker.dashboard');
})->name('worker.dashboard');


// ======================
// CLIENT DASHBOARD
// ======================
Route::get('/client/dashboard', [ClientJobController::class, 'dashboard'])
    ->name('client.client_dashboard');


Route::get('/client/post-job', [ClientJobController::class, 'postJob'])
    ->name('client.client_post_job');

Route::post('/client/jobs/store', [ClientJobController::class, 'store'])
    ->name('client.jobs.store');


Route::get('/client/jobs/create', [ClientJobController::class, 'create'])
    ->name('client.jobs.create');

Route::put('/client/profile/{id}', [ClientJobController::class, 'update'])->name('client.profile.update');

Route::middleware(['auth'])->get(
    '/clientprofile',
    [ClientJobController::class, 'profile']
)->name('client.client_profile');

Route::post(
    '/client/jobs/{job}/complete',
    [ClientJobController::class, 'complete']
)->name('client.jobs.complete');

Route::put(
    '/client/jobs/{job}',
    [ClientJobController::class, 'updateJob']
)->name('client.jobs.update');

Route::delete(
    '/client/jobs/{job}',
    [ClientJobController::class, 'destroy']
)->name('client.jobs.destroy');

Route::get('/client/jobs/{id}/worker', [ClientJobController::class, 'getWorker'])
    ->name('client.jobs.worker');

    Route::post('/client/complaints', [ClientJobController::class, 'storeComplaint'])
     ->name('client.complaints.store');

// ======================
// REGISTRATION (PUBLIC)
// ======================
Route::get('/create-account-user', [ClientRegisterController::class, 'showForm'])
    ->name('client.register.form');

Route::post('/create-account-user', [ClientRegisterController::class, 'register'])
    ->name('client.register.submit');

Route::get('/create-account-worker', [WorkerRegisterController::class, 'create'])
    ->name('worker.register.form');

Route::post('/worker/register', [WorkerRegisterController::class, 'store'])
    ->name('worker.register');


// Route::post('/ai/ask', [GeminiController::class, 'ask'])->name('ai.ask');

Route::get('/check-key', function () {
    return env('GEMINI_API_KEY', 'Key not found!');
});

Route::get('/check-test', function () {
    return env('TEST_ENV', 'Not found!');
});