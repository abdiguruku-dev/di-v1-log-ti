<?php

use Illuminate\Support\Facades\Route;

// Import Semua Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\JamKbmController;
use App\Http\Controllers\MuridController;

/*
|--------------------------------------------------------------------------
| Web Routes (Peta Jalur Aplikasi)
|--------------------------------------------------------------------------
*/

// --- 1. JALUR PUBLIK (LOGIN) ---
Route::get('/', function () { return redirect()->route('login'); });
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- 2. JALUR ADMIN (DAPUR UTAMA) ---
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    
    // A. DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // B. MANAJEMEN SEKOLAH (IDENTITAS & UNIT)
    Route::prefix('sekolah')->name('sekolah.')->group(function() {
        Route::get('/identitas', [SekolahController::class, 'index'])->name('identitas');
        Route::post('/identitas', [SekolahController::class, 'update'])->name('update');
        Route::post('/switch-mode', [SekolahController::class, 'switchMode'])->name('switch_mode');

        // CRUD Unit
        Route::get('/unit', [SekolahController::class, 'unitIndex'])->name('unit.index');
        Route::post('/unit', [SekolahController::class, 'storeUnit'])->name('unit.store');
        Route::put('/unit/update', [SekolahController::class, 'updateUnit'])->name('unit.update');
        Route::get('/unit/{id}/hapus', [SekolahController::class, 'destroyUnit'])->name('unit.delete');
    });


    // C. MASTER AKADEMIK (Group Master)
    Route::prefix('master')->group(function() {
        
        // 1. Tahun Ajaran
        Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun_ajaran.index');
        Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store'])->name('tahun_ajaran.store');
        Route::get('/tahun-ajaran/{id}/aktifkan', [TahunAjaranController::class, 'activate'])->name('tahun_ajaran.activate');
        Route::get('/tahun-ajaran/{id}/hapus', [TahunAjaranController::class, 'destroy'])->name('tahun_ajaran.delete');

        // 2. Jurusan (Kompetensi Keahlian)
        Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
        Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
        Route::get('/jurusan/{id}/hapus', [JurusanController::class, 'destroy'])->name('jurusan.delete');

        // 3. Data Kelas (Rombel)
        Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
        Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/kelas/{id}/hapus', [KelasController::class, 'destroy'])->name('kelas.delete');

        // 4. Master Kurikulum
        Route::get('/kurikulum', [KurikulumController::class, 'index'])->name('kurikulum.index');
        Route::post('/kurikulum', [KurikulumController::class, 'store'])->name('kurikulum.store');
        Route::put('/kurikulum', [KurikulumController::class, 'update'])->name('kurikulum.update');
        Route::get('/kurikulum/{id}/hapus', [KurikulumController::class, 'destroy'])->name('kurikulum.delete');

        // 5. Master Mata Pelajaran
        Route::get('/mapel', [MataPelajaranController::class, 'index'])->name('mapel.index');
        Route::post('/mapel', [MataPelajaranController::class, 'store'])->name('mapel.store');
        Route::put('/mapel', [MataPelajaranController::class, 'update'])->name('mapel.update');
        Route::get('/mapel/{id}/hapus', [MataPelajaranController::class, 'destroy'])->name('mapel.delete');

        // 6. Master Jam Pelajaran
        Route::get('/jam-kbm', [JamKbmController::class, 'index'])->name('jam_kbm.index');
        Route::post('/jam-kbm', [JamKbmController::class, 'store'])->name('jam_kbm.store');
        Route::get('/jam-kbm/{id}/delete', [JamKbmController::class, 'destroy'])->name('jam_kbm.delete');
        Route::post('/jam-kbm/category', [JamKbmController::class, 'storeCategory'])->name('jam_kbm.category.store');
        Route::post('/jam-kbm/activate', [JamKbmController::class, 'activate'])->name('jam_kbm.activate');

    }); // <-- Tutup Group Master


    /// D. MODUL KESISWAAN (Di luar Master, tapi masih dalam Admin)
    Route::prefix('murid')->name('murid.')->group(function () {
        
        // 1. ROUTE SPESIAL (AJAX & IMPORT) - TARUH DI ATAS
        Route::get('/export-excel', [MuridController::class, 'exportExcel'])->name('export_excel');
        Route::get('/export-pdf', [MuridController::class, 'exportPdf'])->name('export_pdf');
        Route::post('/save-draft', [MuridController::class, 'saveDraft'])->name('save_draft'); // <--- INI WAJIB ADA
        Route::post('/import', [MuridController::class, 'import'])->name('import');
        Route::get('/template', [MuridController::class, 'downloadTemplate'])->name('template');

        // 2. ROUTE STANDAR
        Route::get('/', [MuridController::class, 'index'])->name('index');
        Route::get('/create', [MuridController::class, 'create'])->name('create');
        Route::post('/store', [MuridController::class, 'store'])->name('store'); 

        // 3. ROUTE DINAMIS (ID)
        Route::get('/{id}', [MuridController::class, 'show'])->name('show'); 
        Route::get('/{id}/edit', [MuridController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MuridController::class, 'update'])->name('update');
        Route::delete('/{id}', [MuridController::class, 'destroy'])->name('destroy');
    });

});