<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'landing'])->name('landing');

Route::middleware('auth')->group(function () {
    // Breeze Profile Routes
    Route::get('/profile-breeze', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile-breeze', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile-breeze', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Routes
    Route::get('/home', [UserController::class, 'home'])->name('home');
    Route::get('/billing', [UserController::class, 'billing'])->name('billing');
    Route::post('/billing', [UserController::class, 'processBilling'])->name('billing.process');
    Route::get('/billing/success', [UserController::class, 'billingSuccess'])->name('billing.success');
    Route::get('/booking/{id}/receipt', [UserController::class, 'receiptView'])->name('booking.receipt');
    Route::get('/booking/{id}/receipt/pdf', [UserController::class, 'receiptPdf'])->name('booking.receipt.pdf');
    Route::post('/booking/{id}/cancel', [UserController::class, 'cancelBooking'])->name('booking.cancel');
    Route::get('/history', [UserController::class, 'history'])->name('history');
    
    // Custom Profile Route
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/topup', [UserController::class, 'topup'])->name('profile.topup');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        
        Route::get('/computers', [AdminController::class, 'pcIndex'])->name('computers.index');
        Route::post('/computers', [AdminController::class, 'pcStore'])->name('computers.store');
        Route::delete('/computers/{id}', [AdminController::class, 'pcDestroy'])->name('computers.destroy');

        Route::get('/bookings', [AdminController::class, 'bookingIndex'])->name('bookings.index');
        Route::get('/bookings/export/pdf', [AdminController::class, 'exportPdf'])->name('bookings.export.pdf');
        Route::get('/bookings/export/excel', [AdminController::class, 'exportExcel'])->name('bookings.export.excel');
        Route::post('/bookings/{id}/checkin', [AdminController::class, 'checkinBooking'])->name('bookings.checkin');
        Route::post('/bookings/{id}/checkout', [AdminController::class, 'checkoutBooking'])->name('bookings.checkout');

        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('users.destroy');

        Route::get('/canteen', [AdminController::class, 'canteenIndex'])->name('canteen.index');
        Route::post('/canteen', [AdminController::class, 'canteenStore'])->name('canteen.store');
        Route::put('/canteen/{id}', [AdminController::class, 'canteenUpdate'])->name('canteen.update');
        Route::delete('/canteen/{id}', [AdminController::class, 'canteenDestroy'])->name('canteen.destroy');
    });
});

require __DIR__.'/auth.php';
