<?php

use App\Http\Controllers\AdminController;
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

    /* MIN min Admiiinn
     * */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('dashboard');

        //CRUD DOKTER and PASIEN
        Route::get('/dokter', [AdminController::class, 'showUsers'])->name('dokterMaster')->defaults('role', 'dokter');
        Route::post('/dokter', [AdminController::class, 'createUser']);
        Route::get('/dokter/edit/{id}', [AdminController::class, 'getUser']);
        Route::put('/dokter/update/{id}', [AdminController::class, 'updateUser']);
        Route::get('/dokter/delete/{id}', [AdminController::class, 'deleteUser']);

        Route::get('/pasien', [AdminController::class, 'showUsers'])->name('pasienMaster')->defaults('role', 'pasien');
        Route::post('/pasien', [AdminController::class, 'createUser']);
        Route::get('/pasien/edit/{id}', [AdminController::class, 'getUser']);
        Route::put('/pasien/update/{id}', [AdminController::class, 'updateUser']);
        Route::get('/pasien/delete/{id}', [AdminController::class, 'deleteUser']);

        // CRUD OBAT
        Route::get('/obat', [AdminController::class, 'showObat'])->name('obatMaster');
        Route::post('/obat', [AdminController::class, 'createObat']);
        Route::get('/obat/edit/{id}', [AdminController::class, 'editObat']);
        Route::post('/obat/update/{id}', [AdminController::class, 'updateObat']);
        Route::get('/obat/delete/{id}', [AdminController::class, 'deleteObat']);

        //CRUD FOR POLI
        Route::get('/poli', [AdminController::class, 'showPolis'])->name('poliMaster');
        Route::post('/poli', [AdminController::class, 'createPolis'])->name('createPolis');
        Route::get('/poli/edit/{id}', [AdminController::class, 'editPoli'])->name('editPoli');
        Route::post('/poli/update/{id}', [AdminController::class, 'updatePoli'])->name('updatePoli');
        Route::get('/poli/delete/{id}', [AdminController::class, 'deletePoli'])->name('deletePoli');

    });


    /*PASIEN
     * */
    Route::middleware('role:pasien')->prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/dashboard', [PasienController::class, 'pasienDashboard'])->name('dashboard');

        Route::get('/janji-periksa', [PasienController::class, 'showJanjiPeriksaPasien'])->name('janjiPeriksa');
        Route::post('/janji-periksa', [PasienController::class, 'createJanjiPeriksa'])->name('createJanjiPeriksa');
        Route::get('/jadwal-poli/{id}', [PasienController::class, 'jadwalOpenByPoli'])->name('jadwalOpenByPoli');


        Route::get('/riwayat', [PasienController::class, 'showRiwayat'])->name('riwayat');

    });

    /*DOKTER
     * */
    Route::middleware('role:dokter')->prefix('dokter')->name('dokter.')->group(function () {
        Route::get('/dashboard', [DokterController::class, 'dokterDashboard'])->name('dashboard');

        Route::get('/memeriksa', [DokterController::class, 'notYetPeriksa'])->name('memeriksa');
        Route::get('/memeriksa/{id}/edit', [DokterController::class, 'editPeriksa'])->name('memeriksEdit');
        Route::put('/memeriksa/{id}', [DokterController::class, 'memeriksaPasien'])->name('memeriksaPasien');
        Route::delete('/memeriksa/{id}', [DokterController::class, 'deleteJanjiPeriksa'])->name('tolakPeriksa');

        // EDIT PROFILE
        Route::get('/profile/{id}/edit', [DokterController::class, 'getProfile'])->name('dashboardEdit');
        Route::put('/profile/{id}', [DokterController::class, 'editProfile'])->name('updateProfile');

        // CRUD JADWALPERIKSA, name itu alias jadi view bisa pangil langsung
        Route::get('/jadwal', [DokterController::class, 'dokterJadwal'])->name('jadwalPeriksa');
        Route::post('/jadwal', [DokterController::class, 'storeJadwal'])->name('storeJadwal');
        Route::get('/jadwal/edit/{id}', [DokterController::class, 'editJadwal'])->name('editJadwal');
        Route::put('/jadwal/{id}', [DokterController::class, 'updateJadwal'])->name('updateJadwal');
        Route::delete('/jadwal/{id}', [DokterController::class, 'deleteJadwal'])->name('deleteJadwal');

        Route::patch('/jadwal/{id}/toggle-status', [DokterController::class, 'toggleStatusJadwal'])->name('toggleStatusJadwal');

        // HITORY PEMERIKSAAN OLEH DOKTER
        Route::get('/history-periksa', [DokterController::class, 'showHitoryPemeriksaan'])->name('historyPeriksa');

    });
});
