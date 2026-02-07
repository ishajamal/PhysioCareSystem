<?php

use App\Http\Controllers\admin\ManageUser\ManageUserController;
use App\Http\Controllers\Admin\ManageUserController as AdminManageUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\therapist\ManageUsageHistory\UsageHistoryController;
use App\Http\Controllers\therapist\RecordItemUsage\UsageController;
use App\Http\Controllers\admin\ManageMaintenanceRequest\ManageMaintenanceController;
use App\Http\Controllers\Admin\ManageUser\ManageUserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| Guest Routes (Not Logged In)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register routes
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Logged In)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        /*
    |--------------------------------------------------------------------------
    | MANAGE USER ROUTES
    |--------------------------------------------------------------------------
    */
        Route::get('/manage-user', [ManageUserController::class, 'index'])
            ->name('manage.user');

        Route::get('/manage-user/edit/{id}', [ManageUserController::class, 'edit'])
            ->name('manage.user.edit');

        Route::post('/manage-user/update/{id}', [ManageUserController::class, 'update'])
            ->name('manage.user.update');

        Route::delete('/manage-user/delete/{id}', [ManageUserController::class, 'destroy'])
            ->name('manage.user.delete');


        /*
    |--------------------------------------------------------------------------
    | MANAGE MAINTENANCE Routes
    |--------------------------------------------------------------------------
    */
        Route::get('/maintenance', [ManageMaintenanceController::class, 'index'])->name('maintenance.index');
        Route::get('/api/maintenance/notifications', [ManageMaintenanceController::class, 'getNotifications']);
        Route::get('/api/maintenance/count', [ManageMaintenanceController::class, 'getNewCount']);
        Route::post('/api/maintenance/mark-read', [ManageMaintenanceController::class, 'markAsRead']);
        Route::delete('/maintenance/{requestID}', [ManageMaintenanceController::class, 'destroy'])->name('maintenance.destroy');
        Route::get('/maintenance/view/{requestID}', [ManageMaintenanceController::class, 'show'])->name('maintenance.view');
        Route::get('/maintenance/edit/{requestID}', [ManageMaintenanceController::class, 'edit'])->name('maintenance.edit');
        Route::put('/maintenance/update/{requestID}', [ManageMaintenanceController::class, 'update'])->name('maintenance.update');
    });

    /*
    |--------------------------------------------------------------------------
    | THERAPIST Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:therapist')->prefix('therapist')->name('therapist.')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            return view('therapist.dashboard');
        })->name('dashboard');

        //Usage Record
        Route::get('inventory-list', [UsageController::class, 'inventoryList'])->name('inventory.list');
        Route::get('select-item/{itemID}', [UsageController::class, 'selectItem'])->name('select.item');
        Route::get('add-usage-record/{itemID}', [UsageController::class, 'addUsageRecord'])->name('add.usage.record');
        Route::post('store-usage', [UsageController::class, 'storeUsage'])->name('usage.store'); // Store usage record
        Route::get('usage-record', [UsageController::class, 'viewCart'])->name('usage.record');
        Route::get('cart/edit/{itemID}', [UsageController::class, 'editCartItem'])->name('cart.edit');
        Route::post('cart/update/{itemID}', [UsageController::class, 'updateCartItem'])->name('cart.update');
        Route::post('usage/submit', [UsageController::class, 'submitUsageRecord'])->name('cart.submit');
        Route::delete('cart/delete/{itemID}', [UsageController::class, 'deleteCartItem'])->name('cart.delete');
        Route::post('cart/cancel', [UsageController::class, 'cancelUsage'])->name('cart.cancel');


        //Usage History
        Route::get('/usage-history', [UsageHistoryController::class, 'index'])
        ->name('usage.history');
        Route::get('/usage-history/{usageID}', [UsageHistoryController::class, 'show'])
        ->name('view.history.details');
        Route::get('/usage-history/{usageID}/item/{itemID}', [UsageHistoryController::class, 'viewItemDetails'])
        ->name('view.history.item.details');
        Route::get('/usage-history-edit/{usageID}/item/{itemID}', [UsageHistoryController::class, 'edit'])
        ->name('usage.edit');
        Route::put('/usage-history-edit/{usageID}/item/{itemID}', [UsageHistoryController::class, 'update'])
        ->name('usage.update');
        Route::delete('/usage-history/{usageID}/item/{itemID}/delete', [UsageHistoryController::class, 'destroy'])
        ->name('usage.delete');

        // Route::get('/usage-history',[UsageHistoryController::class, 'index'])->name('usage.history');
        // Route::put('/usage-history/{id}',[UsageHistoryController::class, 'update'])->name('usage.update');

        //
    });

    // Logout (must be POST for security)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
