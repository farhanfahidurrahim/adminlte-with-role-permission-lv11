<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::middleware('check_permission')->group(function () {
        // Role & Permission & User
        Route::resource('/roles', RoleController::class);
        Route::resource('/permissions', PermissionController::class);
        Route::resource('/users', UserController::class);

        // Category & Post
        Route::resource('/categories', CategoryController::class);
        Route::resource('/posts', PostController::class);

        Route::get('/my-profile', [ProfileController::class, 'myProfile'])->name('profile.my');
        Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    });
    // Export Excel & PDF
    Route::get('/pdf-download/{modelType}/{id}', [ExportController::class, 'singlePdfDownload'])->name('pdfDownload');
    Route::get('/export/{modelType}', [ExportController::class, 'export'])->name('export');
});

