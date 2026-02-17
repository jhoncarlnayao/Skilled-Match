    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\WorkerRegisterController;
    use App\Http\Controllers\ClientRegisterController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\ClientJobController;
    use App\Http\Controllers\Admin\DashboardController;

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

    // // ======================
    // // ADMIN AREA 
    // // ======================
    // Route::middleware(['auth'])->group(function () {

    //     Route::get('/admindashboard', [DashboardController::class, 'index'])
    //         ->name('admin.dashboard');

    //     Route::get('/admin/pending-accounts', [DashboardController::class, 'pendingAccounts'])
    //         ->name('admin.pending.accounts');

    //     Route::get('/admin/pending-accounts/{id}/approve', [DashboardController::class, 'approve'])
    //         ->name('admin.pending.approve');

    //     Route::get('/admin/pending-accounts/{id}/reject', [DashboardController::class, 'reject'])
    //         ->name('admin.pending.reject');

    //     Route::get('/admin/trades', [DashboardController::class, 'trades'])
    //         ->name('admin.trades');

    //     Route::post('/admin/trades/store', [DashboardController::class, 'storeTrade'])
    //         ->name('admin.trades.store');

    //     Route::post('/admin/trades/{id}/update', [DashboardController::class, 'updateTrade'])
    //         ->name('admin.trades.update');
    // });


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

            Route::get('/client-accounts', [DashboardController::class, 'getClientAccounts'])
        ->name('admin.client.accounts');

        Route::post('/client-accounts/{id}/update', 
        [DashboardController::class, 'updateClient'])
        ->name('admin.client.update');

        Route::get('/admin/client/toggle/{id}', 
        [DashboardController::class, 'toggleClientStatus']
    )->name('admin.client.toggle');


    // Jobs
    Route::get('/jobs', [DashboardController::class, 'ShowJobs'])
    ->name('admin.jobs_list');
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
    Route::get('/client/dashboard', function () {
        return view('client.client_dashboard');
    })->name('client.client_dashboard');

    Route::get('/client/post-job', [ClientJobController::class, 'postJob'])
        ->name('client.client_post_job');

    Route::post('/client/jobs/store', [ClientJobController::class, 'store'])
        ->name('client.jobs.store');

    Route::get('/client/jobs/create', [ClientJobController::class, 'create'])
        ->name('client.jobs.create');

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
