<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemListingController;
use App\Http\Controllers\ListingPhotoController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/explore', [ExploreController::class, 'index'])->name('explore.index');
    Route::get('/explore/{listing}', [ExploreController::class, 'show'])->name('explore.show');
    Route::resource('my-items', ItemListingController::class)
    ->parameters(['my-items' => 'listing'])
    ->names('listings');
    Route::get('/listing-photos/{photo}', [ListingPhotoController::class, 'show'])->name('photos.show');
});