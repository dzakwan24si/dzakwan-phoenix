<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return view('Selamat Datang di Website kampus PCR');
});

Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);

Route::get('/nama/{param1}', function ($param1) {
    return 'Nama saya: '.$param1;
});

Route::get('/nim/{param1?}', function ($param1 = '') {
    return 'NIM saya: '.$param1;
});

Route::get('/about', function () {
    return view('halaman-about');
});

Route::get('/matakuliah', [MatakuliahController::class, 'index']);
Route::get('/matakuliah/show/', [MatakuliahController::class, 'show']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/pegawai', [PegawaiController::class, 'index']);
