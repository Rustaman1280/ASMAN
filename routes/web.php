<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\RuanganController;
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
        Route::resource('ruangans', RuanganController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('barangs', BarangController::class);
        Route::put('unit-barangs/{unitBarang}', [BarangController::class, 'updateUnit'])->name('unit-barangs.update');
        Route::get('barangs/{barang}/units', [BarangController::class, 'units'])->name('barangs.units');
        Route::get('barangs-export', [BarangController::class, 'export'])->name('barangs.export');
        Route::post('barangs-import', [BarangController::class, 'import'])->name('barangs.import');
        Route::get('barangs-template', [BarangController::class, 'downloadTemplate'])->name('barangs.template');

        // Admin only
        Route::middleware('role:admin')->group(function () {
            Route::resource('users', UserController::class);
        }
        );
    });
