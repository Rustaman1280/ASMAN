<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class , 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class , 'logout'])->name('logout');
    Route::get('/', function () {
            return view('dashboard');
        }
        )->name('dashboard');

        // Resource routes (permission checks inside controllers)
        Route::resource('jurusans', JurusanController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('labs', LabController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('barangs', BarangController::class);

        // Admin only
        Route::middleware('role:admin')->group(function () {
            Route::resource('users', UserController::class);
        }
        );
    });
