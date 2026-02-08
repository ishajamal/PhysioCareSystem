<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\therapist\RecordItemUsage\UsageController;
use App\Http\Controllers\admin\ManageItemInformation\InventoryController;
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
        
        Route::get('/inventory', [\App\Http\Controllers\admin\InventoryController::class, 'index'])
        ->name('inventory.dashboard');
    
        Route::get('/inventory/create', [\App\Http\Controllers\admin\InventoryController::class, 'create'])
        ->name('inventory.create');
    
        Route::post('/inventory/store', [\App\Http\Controllers\admin\InventoryController::class, 'store'])
        ->name('inventory.store');
    
    // ADD THESE NEW ROUTES:
        Route::get('/inventory/{id}', [\App\Http\Controllers\admin\InventoryController::class, 'show'])
        ->name('inventory.show');
    
        Route::get('/inventory/{id}/edit', [\App\Http\Controllers\admin\InventoryController::class, 'edit'])
        ->name('inventory.edit');
    
        Route::put('/inventory/{id}', [\App\Http\Controllers\admin\InventoryController::class, 'update'])
        ->name('inventory.update');
    
        Route::delete('/inventory/{id}', [\App\Http\Controllers\admin\InventoryController::class, 'destroy'])
        ->name('inventory.destroy');

        // ADD THESE ROUTES FOR EDIT FUNCTIONALITY:
        Route::get('/inventory/{id}', [\App\Http\Controllers\admin\InventoryController::class, 'show'])
        ->name('inventory.show');
    
        Route::get('/inventory/{id}/edit', [\App\Http\Controllers\admin\InventoryController::class, 'edit'])
        ->name('inventory.edit');
    
        Route::put('/inventory/{id}', [\App\Http\Controllers\admin\InventoryController::class, 'update'])
        ->name('inventory.update');
    
        Route::delete('/inventory/{id}', [\App\Http\Controllers\admin\InventoryController::class, 'destroy'])
        ->name('inventory.destroy');

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


    });
    
    // Logout (must be POST for security)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});