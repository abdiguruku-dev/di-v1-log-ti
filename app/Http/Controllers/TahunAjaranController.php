<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahun_ajaran = DB::table('tahun_ajarans')->orderBy('id', 'desc')->get();
        return view('admin.master.tahun_ajaran', compact('tahun_ajaran'));
    }

    public function store(Request $request)
    {
        $request->validate(['tahun_ajaran' => 'required', 'semester' => 'required']);

        DB::table('tahun_ajarans')->insert([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'is_active' => 0, // Default tidak aktif
            'created_at' => now()
        ]);

        return back()->with('success', 'Tahun Ajaran berhasil dibuat!');
    }

    public function activate($id)
    {
        // Matikan semua dulu
        DB::table('tahun_ajarans')->update(['is_active' => 0]);
        // Aktifkan yang dipilih
        DB::table('tahun_ajarans')->where('id', $id)->update(['is_active' => 1]);

        return back()->with('success', 'Tahun Ajaran Aktif Berhasil Diganti!');
    }

    public function destroy($id)
    {
        // CEK KETERKAITAN DATA (GERBANG KELUAR)
        
        // Cek apakah TA ini dipakai di Data Kelas?
        $cekKelas = DB::table('kelas')->where('tahun_ajaran_id', $id)->count();
        
        if ($cekKelas > 0) {
            return back()->with('error', "BAHAYA! Tahun Ajaran ini memuat $cekKelas Kelas aktif. Tidak bisa dihapus sembarangan karena akan menghilangkan riwayat siswa.");
        }

        DB::table('tahun_ajarans')->delete($id);
        return back()->with('success', 'Tahun Ajaran dihapus.');
    }
}