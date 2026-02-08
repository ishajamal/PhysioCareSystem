<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\admin\ManageUser\ManageUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\therapist\ManageUsageHistory\UsageHistoryController;
use App\Http\Controllers\therapist\RecordItemUsage\UsageController;
use App\Http\Controllers\admin\ManageMaintenanceRequest\ManageMaintenanceController;
<<<<<<< HEAD
use App\Http\Controllers\therapist\therapistDashboardController;
=======
use App\Http\Controllers\therapist\ItemDetails\ItemDetailsController;
use App\Http\Controllers\therapist\SubmitMaintenanceRequest\MaintenanceRequestController;
>>>>>>> 559dcb3 (Therapist: item details + maintenance request + sidebar/pagination fixes (remove unused files))
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
       Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
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
            Route::get('/dashboard', [therapistDashboardController::class, 'index'])->name('dashboard');


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

        // View Item Details
        Route::get('items', [ItemDetailsController::class, 'index'])->name('items.index');
        Route::get('items/{itemID}', [ItemDetailsController::class, 'show'])->name('items.show');

        // Maintenance Request (History + Submit)
        Route::get('maintenance-request', [MaintenanceRequestController::class, 'index'])->name('maintenance.index');
        Route::get('maintenance-request/create', [MaintenanceRequestController::class, 'create'])->name('maintenance.create');
        Route::post('maintenance-request', [MaintenanceRequestController::class, 'store'])->name('maintenance.store');
        Route::get('maintenance-request/{requestID}', [MaintenanceRequestController::class, 'show'])->name('maintenance.show');

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
        Route::get('/list-item/{usageID}',[UsageHistoryController::class,'inventoryList'])
        ->name('usage.list');
        Route::get('/add-new-record/{usageID}/item/{itemID}', [UsageHistoryController::class, 'addNewRecord'])->name('add.new.record');
        Route::post('/usage/{usageID}/store-item',[UsageHistoryController::class, 'storeNewUsage'])->name('usage.item.store');
        Route::delete('/usage/{id}/delete', [UsageHistoryController::class, 'delete'])->name('delete.usage');

    });

    // Logout (must be POST for security)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
