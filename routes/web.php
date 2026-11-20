<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminGuestbookController;
use App\Http\Controllers\GuestbookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuestbookController::class, 'index'])->name('guestbook.index');
Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'store'])->middleware('throttle:6,1')->name('login.store');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
    Route::get('/guestbook', [AdminGuestbookController::class, 'create'])->name('guestbook.create');
    Route::post('/guestbook', [AdminGuestbookController::class, 'store'])->name('guestbook.store');
});
