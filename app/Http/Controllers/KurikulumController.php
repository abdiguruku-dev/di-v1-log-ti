<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KurikulumController extends Controller
{
    public function index()
    {
        // Urutkan berdasarkan tahun agar sejarah terlihat rapi
        $kurikulum = DB::table('kurikulums')->orderBy('tahun_mulai', 'desc')->get();
        return view('admin.master.kurikulum', compact('kurikulum'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kurikulum' => 'required',
            'tahun_mulai' => 'required|digits:4',
            'label_periode' => 'required',
            'jumlah_periode' => 'required|integer|min:1|max:12', // Max 12 bulan
            'dokumen' => 'nullable|mimes:pdf|max:5120' // Max 5MB
        ]);

        $pathDokumen = null;
        if ($request->hasFile('dokumen')) {
            $pathDokumen = $request->file('dokumen')->store('uploads/kurikulum', 'public');
        }

        DB::table('kurikulums')->insert([
            'nama_kurikulum' => $request->nama_kurikulum,
            'tahun_mulai' => $request->tahun_mulai,
            'label_periode' => $request->label_periode, // Flexibel
            'jumlah_periode' => $request->jumlah_periode, // Flexibel
            'skala_nilai' => $request->skala_nilai,
            'keterangan' => $request->keterangan,
            'dokumen_pendukung' => $pathDokumen,
            'is_active' => 1,
            'created_at' => now()
        ]);

        return back()->with('success', 'Kurikulum berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate(['id' => 'required', 'nama_kurikulum' => 'required']);

        $dataLama = DB::table('kurikulums')->where('id', $request->id)->first();
        $pathDokumen = $dataLama->dokumen_pendukung;

        if ($request->hasFile('dokumen')) {
            if ($pathDokumen && Storage::exists('public/' . $pathDokumen)) {
                Storage::delete('public/' . $pathDokumen);
            }
            $pathDokumen = $request->file('dokumen')->store('uploads/kurikulum', 'public');
        }

        DB::table('kurikulums')->where('id', $request->id)->update([
            'nama_kurikulum' => $request->nama_kurikulum,
            'tahun_mulai' => $request->tahun_mulai,
            'label_periode' => $request->label_periode,
            'jumlah_periode' => $request->jumlah_periode,
            'skala_nilai' => $request->skala_nilai,
            'is_active' => $request->is_active,
            'keterangan' => $request->keterangan,
            'dokumen_pendukung' => $pathDokumen,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Kurikulum berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = DB::table('kurikulums')->where('id', $id)->first();
        if ($data->dokumen_pendukung && Storage::exists('public/' . $data->dokumen_pendukung)) {
            Storage::delete('public/' . $data->dokumen_pendukung);
        }
        
        DB::table('kurikulums')->delete($id);
        return back()->with('success', 'Kurikulum dihapus.');
    }
}