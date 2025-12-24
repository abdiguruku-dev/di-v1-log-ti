<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Http\Requests\StoreKelasRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        // 1. AMBIL CONFIG (OTOMATIS)
        // Controller langsung baca dari database: "Sekolah ini jenjangnya apa?"
        $jenjangSekolah = \Illuminate\Support\Facades\DB::table('sekolah_configs')->value('jenjang');
        
        // Safety net: Kalau config kosong, default ke SMA
        if (!$jenjangSekolah) {
            $jenjangSekolah = 'SMA'; 
        }

        // 2. QUERY DATA (Terkunci Otomatis)
        // Kita tidak lagi bertanya ke $request. Kita langsung pakai $jenjangSekolah.
        $query = Kelas::with('jurusan');

        // Filter: Hanya tampilkan kelas yang jurusannya sesuai Config Sekolah
        $query->whereHas('jurusan', function($q) use ($jenjangSekolah) {
            $q->where('jenjang', $jenjangSekolah);
        });

        $kelas = $query->orderBy('nama_kelas', 'asc')->get();

        // 3. DATA JURUSAN (Untuk Modal Tambah)
        // Dropdown Jurusan saat tambah kelas juga otomatis disaring
        $jurusans = Jurusan::where('jenjang', $jenjangSekolah)->get();

        // 4. Kirim ke View
        // Variabel $jenjangPilih kita hapus karena sudah tidak dipakai
        return view('admin.master.kelas', compact('kelas', 'jurusans', 'jenjangSekolah'));
    }

    public function store(StoreKelasRequest $request)
    {
        // Validasi sudah otomatis dijalankan oleh StoreKelasRequest.
        // Jika gagal, Laravel otomatis menendang balik ke form dengan pesan error.
        // Controller hanya fokus pada logika simpan data.

        // Ambil TA Aktif otomatis
        $taAktif = DB::table('tahun_ajarans')->where('is_active', 1)->first();

        // Jika tidak ada Tahun Ajaran aktif, kembalikan error (Safety Net)
        if (!$taAktif) {
            return back()->with('error', 'Tidak ada Tahun Ajaran yang aktif! Hubungi Admin.');
        }

        DB::table('kelas')->insert([
            'tahun_ajaran_id' => $taAktif->id,
            'nama_kelas'      => $request->nama_kelas,
            'tingkat'         => $request->tingkat,
            'jurusan_id'      => $request->jurusan_id,
            'wali_kelas'      => $request->wali_kelas,
            'created_at'      => now()
        ]);

        return back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        // CEK KETERKAITAN DATA
        // $cekSiswa = DB::table('siswas')->where('kelas_id', $id)->count(); 
        $cekSiswa = 0; // Sementara 0 dulu sampai tabel siswa ada

        if ($cekSiswa > 0) {
            return back()->with('error', "GAGAL HAPUS! Ada $cekSiswa siswa di dalam kelas ini. Keluarkan atau pindahkan siswa terlebih dahulu.");
        }

        DB::table('kelas')->delete($id);
        return back()->with('success', 'Kelas berhasil dihapus.');
    }
}