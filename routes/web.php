<?php

use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return redirect()->route('login');
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

    /*PASIEN
     * */
    Route::middleware('role:pasien')->prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/dashboard', [PasienController::class, 'pasienDashboard'])->name('dashboard');
        Route::get('/periksa', [PasienController::class, 'showPeriksaForm'])->name('periksa');
        Route::post('/periksa', [PasienController::class, 'createPeriksa']);
        Route::get('/riwayat', [PasienController::class, 'showRiwayat'])->name('riwayat');
    });

    /*DOKTER
     * */
    Route::middleware('role:dokter')->prefix('dokter')->name('dokter.')->group(function () {

        Route::get('/dashboard', [DokterController::class, 'dokterDashboard'])->name('dashboard');

        Route::get('/periksa', [DokterController::class, 'periksa'])->name('periksa');
        Route::get('/periksa/{id}/edit', [DokterController::class, 'editPeriksa'])->name('editPeriksa');
        Route::put('/periksa/{id}', [DokterController::class, 'updatePeriksa'])->name('updatePeriksa');
        Route::delete('/periksa/{id}', [DokterController::class, 'deletePeriksa'])->name('deletePeriksa');

        Route::get('/obat', [DokterController::class, 'showObat'])->name('obat');
        Route::post('/obat', [DokterController::class, 'createObat']);
        Route::get('/obat/edit/{id}', [DokterController::class, 'editObat']);
        Route::post('/obat/update/{id}', [DokterController::class, 'updateObat']);
        Route::get('/obat/delete/{id}', [DokterController::class, 'deleteObat']);
    });
});
