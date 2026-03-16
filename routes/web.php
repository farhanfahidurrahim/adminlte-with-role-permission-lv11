<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\XyzController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    // Form
    Route::get('form-general', [XyzController::class, 'formGeneral'])->name('form.general');
    Route::get('form-advanced', [XyzController::class, 'formAdvanced'])->name('form.advanced');
    Route::get('form-editors', [XyzController::class, 'formEditors'])->name('form.editors');
    Route::get('form-validation', [XyzController::class, 'formValidation'])->name('form.validation');
    // DataTable
    Route::get('bootstrap-datatable', [XyzController::class, 'bootstrapDataTable'])->name('datatable.bootstrap');
    Route::get('jquery-datatable', [XyzController::class, 'jquery'])->name('datatable.jquery');
    Route::get('yajra-datatable', [XyzController::class, 'yajra'])->name('datatable.yajra');

    Route::middleware('check_permission')->group(function () {
        // Role & Permission & User
        Route::resource('/roles', RoleController::class);
        Route::resource('/permissions', PermissionController::class);
        Route::resource('/users', UserController::class);

        // Category & Post
        Route::resource('/categories', CategoryController::class);
        Route::resource('/posts', PostController::class);

        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

        Route::get('/my-profile', [ProfileController::class, 'myProfile'])->name('profile.my');
        Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    });
    // Export Excel & PDF
    Route::get('/pdf-download/{modelType}/{id}', [ExportController::class, 'singlePdfDownload'])->name('pdfDownload');
    Route::get('/export/{modelType}', [ExportController::class, 'export'])->name('export');
});
