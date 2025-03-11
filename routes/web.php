<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);


Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//DASHBOARD AUTHENTICATION
Route::middleware(['auth'])->group(function () {
    // Route untuk pasien
    Route::get('/pasien-dashboard', function () {
        return view('pages.dashboard_pasien');
    })->name('pasien.dashboard');

    // Route untuk dokter
    Route::get('/dokter-dashboard', function () {
        return view('pages.dashboard_dokter');
    })->name('dokter.dashboard');

    // Route untuk master chat
    Route::get('/master-chat', function () {
        return view('pages.master_chat');
    })->name('master.chat');
});

