<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemListingController;
use App\Http\Controllers\ListingPhotoController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SharingRequestController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProfileController;

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
    Route::get('/explore/{listing}/request', [SharingRequestController::class, 'create'])->name('requests.create');
    Route::post('/explore/{listing}/request', [SharingRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{sharingRequest}', [SharingRequestController::class, 'show'])->name('requests.show');
    Route::post('/requests/{sharingRequest}/accept', [SharingRequestController::class, 'accept'])->name('requests.accept');
    Route::post('/requests/{sharingRequest}/reject', [SharingRequestController::class, 'reject'])->name('requests.reject');
    Route::delete('/requests/{sharingRequest}', [SharingRequestController::class, 'cancel'])->name('requests.cancel');
    Route::get('/my-transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/requests', [SharingRequestController::class, 'index'])->name('requests.index');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});