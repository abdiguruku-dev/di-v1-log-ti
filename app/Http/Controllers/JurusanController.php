<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreJurusanRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JurusanController extends Controller
{
   public function index()
    {
        // 1. Cek Jenjang Sekolah Aktif
        $jenjangSekolah = \Illuminate\Support\Facades\DB::table('sekolah_configs')->value('jenjang');
        
        // Default ke SMA jika config kosong
        if (!$jenjangSekolah) {
            $jenjangSekolah = 'SMA';
        }

        // 2. Ambil Data Jurusan (FILTER BERDASARKAN JENJANG)
        // Kita gunakan 'where' agar ID 1 (yang nanti kita set jadi SMA) tidak muncul di SD/SMP
        $jurusans = \App\Models\Jurusan::where('jenjang', $jenjangSekolah)
                                        ->orderBy('kode_jurusan', 'asc') // Biar rapi
                                        ->get();

        // 3. Kirim ke View
        return view('admin.master.jurusan', compact('jurusans', 'jenjangSekolah'));
    }
    
   public function store(StoreJurusanRequest $request)
    {
        // Validasi otomatis dijalankan oleh StoreJurusanRequest
        // Jika lolos, kode di bawah ini baru dieksekusi

        DB::table('jurusans')->insert([
            'kode_jurusan' => strtoupper($request->kode_jurusan), // Paksa huruf besar
            'nama_jurusan' => $request->nama_jurusan,
            'jenjang'      => $request->jenjang,
            'keterangan'   => $request->keterangan, // Opsional
            'created_at'   => now()
        ]);

        return back()->with('success', 'Jurusan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        // 2. CEK KETERKAITAN DATA (GERBANG KELUAR)
        
        // Cek apakah dipakai di Kelas?
        $cekKelas = DB::table('kelas')->where('jurusan_id', $id)->count();
        if ($cekKelas > 0) {
            return back()->with('error', "GAGAL HAPUS! Jurusan ini sedang dipakai oleh $cekKelas Kelas. Hapus dulu kelasnya.");
        }

        // Cek apakah dipakai di Mata Pelajaran?
        $cekMapel = DB::table('mata_pelajarans')->where('jurusan_id', $id)->count();
        if ($cekMapel > 0) {
            return back()->with('error', "GAGAL HAPUS! Jurusan ini terikat dengan $cekMapel Mata Pelajaran Khusus. Ubah dulu mapelnya menjadi Umum atau pindahkan jurusan.");
        }

        // Jika lolos, baru hapus
        DB::table('jurusans')->delete($id);
        return back()->with('success', 'Jurusan berhasil dihapus.');
    }
}