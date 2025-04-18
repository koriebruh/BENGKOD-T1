<?php

use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Middleware\CheckDokter;
use App\Models\Periksa;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ObatController;


Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);


Route::aliasMiddleware('dokter', CheckDokter::class);
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//DASHBOARD AUTHENTICATION
Route::middleware(['auth'])->group(function () {
    // Route untuk pasien
//    Route::get('/pasien/dashboard', function () {
//        PasienController::class
//        return view('pasien.dashboard', );
//    })->name('pasien.dashboard');
    Route::get('/pasien/dashboard', [PasienController::class, 'pasienDashboard'])->name('pasien.dashboard');
    Route::get('/pasien/periksa', [PasienController::class, 'showPeriksaForm'])->name('pasien.periksa');
    Route::post('/pasien/periksa', [PasienController::class, 'createPeriksa']);

    /*
     * RETURN VIEW PASIEN PERIKSA AND HASIL QUERY KE DATABASE
     * */
    Route::get('/pasien/riwayat', [PasienController::class, 'showRiwayat'])->name('pasien.riwayat');


    // Route untuk dokter
    Route::middleware(['dokter'])->group(function () {
        // Dashboard dokter
        Route::get('/dokter/dashboard', function () {
            return view('dokter.dashboard');
        })->name('dokter.dashboard');
        Route::get('/dokter/dashboard', [DokterController::class, 'dokterDashboard'])->name('dokter.dashboard');



        Route::get('/dokter/periksa', function () {return view('dokter.periksa');})->name('dokter.periksa');
        Route::get('/dokter/periksa', [DokterController::class, 'periksa'])->name('dokter.periksa');
        Route::middleware('auth')->prefix('dokter')->group(function () {
            Route::get('periksa', [DokterController::class, 'periksa'])->name('dokter.periksa');
            Route::get('periksa/{id}/edit', [DokterController::class, 'editPeriksa'])->name('dokter.editPeriksa');
            Route::put('periksa/{id}', [DokterController::class, 'updatePeriksa'])->name('dokter.updatePeriksa');
            Route::delete('periksa/{id}', [DokterController::class, 'deletePeriksa'])->name('dokter.deletePeriksa');
        });

        // CRUD untuk obat
        Route::prefix('dokter')->name('dokter.')->group(function () {
            Route::get('/obat', [DokterController::class, 'showObat'])->name('obat');
            Route::post('/obat', [DokterController::class, 'createObat']);
            Route::get('/obat/edit/{id}', [DokterController::class, 'editObat']);
            Route::post('/obat/update/{id}', [DokterController::class, 'updateObat']);
            Route::get('/obat/delete/{id}', [DokterController::class, 'deleteObat']);

        });

//        Route::get('/periksa', [DokterController::class, 'showPeriksa'])->name('periksa'); // Menampilkan periksa
    });

    // Route untuk master chat
    Route::get('/master-chat', function () {
        return view('pages.master_chat');
    })->name('master.chat');
});
