<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('elearhome');
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/dashboard/mahasiswa', [AuthController::class, 'mahasiswaDashboard'])->name('dashboard.mahasiswa');
Route::get('/dashboard/dosen', [AuthController::class, 'dosenDashboard'])->name('dashboard.dosen');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
