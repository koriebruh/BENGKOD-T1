<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ObatController;


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
    Route::middleware(['dokter'])->group(function () {
        // Dashboard dokter
        Route::get('/dokter-dashboard', function () {
            return view('pages.dashboard_dokter');
        })->name('dokter.dashboard');

        // CRUD untuk obat
        Route::prefix('dokter')->name('dokter.')->group(function () {
            Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
            Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');
            Route::put('/obat/{id}', [ObatController::class, 'update'])->name('obat.update');
            Route::delete('/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');
        });
    });

    // Route untuk master chat
    Route::get('/master-chat', function () {
        return view('pages.master_chat');
    })->name('master.chat');
});
