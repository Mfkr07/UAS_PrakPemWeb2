<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', [PublicController::class, 'landing'])->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User Routes
    Route::get('/home', [UserController::class, 'home'])->name('home');
    Route::get('/billing', [UserController::class, 'billing'])->name('billing');
    Route::post('/billing', [UserController::class, 'processBilling'])->name('billing.process');
    Route::get('/billing/success', [UserController::class, 'billingSuccess'])->name('billing.success');
    Route::get('/book/{id}', [UserController::class, 'book'])->name('user.book');
    Route::post('/book/{id}', [UserController::class, 'store'])->name('user.store');
    Route::get('/history', [UserController::class, 'history'])->name('history');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/topup', [UserController::class, 'topup'])->name('profile.topup');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/computers', [AdminController::class, 'pcIndex'])->name('computers.index');
        Route::post('/computers', [AdminController::class, 'pcStore'])->name('computers.store');
        Route::delete('/computers/{id}', [AdminController::class, 'pcDestroy'])->name('computers.destroy');

        Route::get('/bookings', [AdminController::class, 'bookingIndex'])->name('bookings.index');
        Route::post('/bookings/{id}/finish', [AdminController::class, 'finishBooking'])->name('bookings.finish');

        Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('users.destroy');

        Route::get('/canteen', [AdminController::class, 'canteenIndex'])->name('canteen.index');
        Route::post('/canteen', [AdminController::class, 'canteenStore'])->name('canteen.store');
        Route::put('/canteen/{id}', [AdminController::class, 'canteenUpdate'])->name('canteen.update');
        Route::delete('/canteen/{id}', [AdminController::class, 'canteenDestroy'])->name('canteen.destroy');
    });
});
