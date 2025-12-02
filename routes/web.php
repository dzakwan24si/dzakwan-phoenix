<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\MultipleuploadsController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return "Selamat Datang di Website kampus PCR";
});

Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);

Route::get('/nama/{param1}', function ($param1) {
    return 'Nama saya: ' . $param1;
});

Route::get('/nim/{param1?}', function ($param1 = '') {
    return 'NIM saya: ' . $param1;
});

Route::get('/about', function () {
    return view('halaman-about');
});

Route::get('/matakuliah', [MatakuliahController::class, 'index']);
Route::get('/matakuliah/show/', [MatakuliahController::class, 'show']);
Route::get('/home', [HomeController::class, 'index'])
    ->name('home');
Route::get('/pegawai', [PegawaiController::class, 'index']);
Route::post('question/store', [QuestionController::class, 'store'])
    ->name('question.store');

Route::post('/upload/store', [MultipleuploadsController::class, 'store'])->name('upload.store');
Route::delete('/upload/destroy/{id}', [MultipleuploadsController::class, 'destroy'])->name('upload.destroy');

Route::get('auth', [AuthController::class, 'index'])->name('auth');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

//Untuk banyak route
Route::group(['middleware' => ['checkislogin']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('pelanggan', PelangganController::class);
    Route::resource('user', UserController::class);

});

Route::group(['middleware' => ['checkrole:Admin']], function () {
    Route::get('user',[UserController::class, 'index'])->name('user.index');
});
