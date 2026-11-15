<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemListingController;
use App\Http\Controllers\ListingPhotoController;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/home', fn () => view('home'))->name('home');
    Route::resource('my-items', ItemListingController::class)
    ->parameters(['my-items' => 'listing'])
    ->names('listings');
    Route::get('/listing-photos/{photo}', [ListingPhotoController::class, 'show'])->name('photos.show');
});