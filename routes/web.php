<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\PicturesVideosController;

Route::get('/pictures-videos', [PicturesVideosController::class, 'index'])->name('pictures_videos');
Route::get('/pictures-videos/{category}', [PicturesVideosController::class, 'showCategory'])->name('pictures_videos.category');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/profile/update', [AdminDashboardController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/admin/users/{id}/approve', [AdminDashboardController::class, 'approveUser'])->name('admin.users.approve');
    Route::post('/admin/users/{id}/reject', [AdminDashboardController::class, 'rejectUser'])->name('admin.users.reject');
    Route::post('/admin/media/delete', [AdminDashboardController::class, 'deleteMedia'])->name('admin.media.delete');
    
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/user/profile/update', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
    
    // Media upload route
    Route::post('/pictures-videos/{category}/upload', [PicturesVideosController::class, 'uploadMedia'])->name('pictures_videos.upload');
});
