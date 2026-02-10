<?php

use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LabController;

Route::get('/', function () {
    return view('dashboard');
});

Route::resource('jurusans', JurusanController::class);
Route::resource('kelas', KelasController::class);
Route::resource('labs', LabController::class);
