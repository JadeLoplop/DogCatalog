<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/like-image', [LikeController::class, 'likeImage']);
    Route::get('/liked-images', [LikeController::class, 'getLikedImages']);
    Route::get('/user-liked-images/{user_id}', [LikeController::class, 'getUserLikedImages']);
});

Route::middleware('auth')->group(function () {
    Route::get('/users', [DashboardController::class, 'getUsers']);
});

Route::prefix('dog-services')->middleware('auth')->group(function () {
    Route::get('/dog-breeds', [DogController::class, 'getListBreeds']);
    Route::get('/random-dog/{count?}', [DogController::class, 'getRandomDog']);
});

require __DIR__.'/auth.php';
