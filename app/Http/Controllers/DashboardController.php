<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. DATA IDENTITAS & USER
        $user = Auth::user();
        $config = DB::table('sekolah_configs')->first();
        
        $mode = session('mode_aplikasi', $config->mode_aplikasi ?? 'TUNGGAL');
        
        $namaUnit = null;
        if($user->unit_id) {
            $unit = DB::table('unit_sekolah')->where('id', $user->unit_id)->first();
            $namaUnit = $unit->nama_unit ?? '';
        }

        // 2. DATA AKADEMIK
        $taAktif = DB::table('tahun_ajarans')->where('is_active', 1)->first();
        
        // 3. HITUNG STATISTIK (SUDAH DIPERBAIKI)
        // Menggunakan tabel 'murids' (bukan siswas) dan menghitung status 'Aktif'
        $totalSiswa = Schema::hasTable('murids') ? DB::table('murids')->where('status_murid', 'Aktif')->count() : 0;
        
        $totalGuru  = Schema::hasTable('users') ? DB::table('users')->where('role', '!=', 'superadmin')->count() : 0;

        $stats = [
            'total_jurusan' => DB::table('jurusans')->count(),
            'total_kelas'   => DB::table('kelas')->where('tahun_ajaran_id', $taAktif->id ?? 0)->count(),
            'total_mapel'   => DB::table('mata_pelajarans')->where('is_active', 1)->count(),
            'total_unit'    => ($mode == 'TERPADU') ? DB::table('unit_sekolah')->count() : 0,
            
            'total_siswa'   => $totalSiswa, // Fix: mengambil data dari murids
            'total_sdm'     => $totalGuru,
        ];

        return view('admin.dashboard.index', compact('config', 'mode', 'user', 'namaUnit', 'taAktif', 'stats'));
    }
}