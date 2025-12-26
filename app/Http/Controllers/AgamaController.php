<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use Illuminate\Http\Request;

class AgamaController extends Controller
{
    // 1. TAMPILKAN HALAMAN UTAMA
    public function index()
    {
        $agamas = Agama::latest()->get();
        return view('admin.master.agama.index', compact('agamas'));
    }

    // 2. SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_agama' => 'required|unique:agamas,nama_agama'
        ], [
            'nama_agama.required' => 'Nama Agama wajib diisi!',
            'nama_agama.unique' => 'Agama ini sudah ada!'
        ]);

        Agama::create($request->all());
        return back()->with('success', 'Agama berhasil ditambahkan!');
    }

    // 3. UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_agama' => 'required|unique:agamas,nama_agama,'.$id
        ]);

        $agama = Agama::findOrFail($id);
        $agama->update($request->all());
        return back()->with('success', 'Data berhasil diperbarui!');
    }

    // 4. HAPUS DATA
    public function destroy($id)
    {
        // Cek dulu apakah agama ini dipakai oleh murid?
        $cekMurid = \App\Models\Murid::where('agama_id', $id)->count();
        
        if($cekMurid > 0) {
            return back()->with('error', 'Gagal hapus! Masih ada '.$cekMurid.' siswa yang memeluk agama ini.');
        }

        $agama = Agama::findOrFail($id);
        $agama->delete();
        return back()->with('success', 'Agama berhasil dihapus!');
    }
}