<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JamKbmController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Kategori yang sedang dipilih user (atau default ke yang AKTIF)
        $activeCategory = DB::table('kategori_jadwal')->where('is_aktif', 1)->first();
        
        // Jika ada parameter 'kategori_id' di URL, pakai itu. Jika tidak, pakai yang aktif.
        $selectedId = $request->get('kategori_id', $activeCategory->id ?? 1);
        
        // 2. Ambil Semua Kategori untuk Dropdown Pilihan
        $categories = DB::table('kategori_jadwal')->get();
        
        // 3. Ambil Detail Jam sesuai Kategori Terpilih
        $jam = DB::table('jam_kbm')
                ->where('kategori_id', $selectedId)
                ->orderBy('jam_ke', 'ASC')
                ->get();

        // Ambil info kategori yang sedang dilihat
        $currentCategory = DB::table('kategori_jadwal')->where('id', $selectedId)->first();

        return view('admin.akademik.jam_kbm', compact('categories', 'jam', 'currentCategory', 'selectedId'));
    }

    // SIMPAN JAM PELAJARAN
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'jam_ke' => 'required|numeric',
            'mulai' => 'required', // Format H:i otomatis divalidasi
            'selesai' => 'required',
        ]);

        DB::table('jam_kbm')->insert([
            'kategori_id'   => $request->kategori_id,
            'jam_ke'        => $request->jam_ke,
            'mulai'         => $request->mulai,
            'selesai'       => $request->selesai,
            'mulai_jumat'   => $request->mulai_jumat,
            'selesai_jumat' => $request->selesai_jumat,
            'keterangan'    => $request->keterangan,
            'created_at'    => now()
        ]);

        return back()->with('success', 'Jam berhasil ditambahkan.');
    }

    // AKTIFKAN KATEGORI JADWAL
    public function activate(Request $request)
    {
        // Reset semua jadi 0
        DB::table('kategori_jadwal')->update(['is_aktif' => 0]);
        
        // Set yang dipilih jadi 1
        DB::table('kategori_jadwal')->where('id', $request->id)->update(['is_aktif' => 1]);

        return back()->with('success', 'Jadwal berhasil diaktifkan! Sistem Akademik & Bel akan menggunakan jadwal ini.');
    }

    // HAPUS JAM
    public function destroy($id)
    {
        DB::table('jam_kbm')->where('id', $id)->delete();
        return back()->with('success', 'Jam berhasil dihapus.');
    }
    
    // TAMBAH KATEGORI BARU
    public function storeCategory(Request $request)
    {
        DB::table('kategori_jadwal')->insert([
            'nama_jadwal' => $request->nama_jadwal,
            'is_aktif' => 0,
            'created_at' => now()
        ]);
        return back()->with('success', 'Kategori Jadwal Baru dibuat.');
    }
}