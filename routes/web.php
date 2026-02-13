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
        Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
        Route::get('kelas/{kelas}/export-barang', [KelasController::class, 'exportBarang'])->name('kelas.export-barang');
        Route::post('kelas/{kelas}/import-barang', [KelasController::class, 'importBarang'])->name('kelas.import-barang');
        Route::get('kelas-template', [KelasController::class, 'downloadTemplate'])->name('kelas.template');
        Route::resource('labs', LabController::class);
        Route::get('labs/{lab}/export-barang', [LabController::class, 'exportBarang'])->name('labs.export-barang');
        Route::post('labs/{lab}/import-barang', [LabController::class, 'importBarang'])->name('labs.import-barang');
        Route::get('labs-template', [LabController::class, 'downloadTemplate'])->name('labs.template');
        Route::resource('suppliers', SupplierController::class);
        Route::resource('barangs', BarangController::class);
        Route::get('barangs-export', [BarangController::class, 'export'])->name('barangs.export');
        Route::post('barangs-import', [BarangController::class, 'import'])->name('barangs.import');
        Route::get('barangs-template', [BarangController::class, 'downloadTemplate'])->name('barangs.template');

        // Admin only
        Route::middleware('role:admin')->group(function () {
            Route::resource('users', UserController::class);
        }
        );
    });
