<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MataPelajaranController extends Controller
{
    public function index()
    {
        // 1. CEK PRASYARAT (GERBANG MASUK)
        $config = DB::table('sekolah_configs')->first();
        $mode = $config->mode_aplikasi ?? 'TUNGGAL';
        $user = Auth::user();

        // Cek Jenjang di Mode Tunggal
        if ($mode == 'TUNGGAL' && empty($config->jenjang)) {
            return redirect()->route('admin.sekolah.identitas')
                ->with('error', 'STOP! Anda harus memilih JENJANG SEKOLAH dulu sebelum mengisi Mata Pelajaran.');
        }

        // ... (Logika Auto Jenjang Tetap Sama) ...
        $autoJenjang = null; 
        if ($mode == 'TUNGGAL') {
            $autoJenjang = $config->jenjang; 
        } elseif ($user->unit_id) {
            $unit = DB::table('sekolah_units')->where('id', $user->unit_id)->first();
            $autoJenjang = $unit->jenjang ?? null;
        }

        $query = DB::table('mata_pelajarans')
                    ->leftJoin('jurusans', 'mata_pelajarans.jurusan_id', '=', 'jurusans.id')
                    ->select('mata_pelajarans.*', 'jurusans.nama_jurusan');
        
        if ($autoJenjang) {
            $query->where('mata_pelajarans.jenjang', $autoJenjang);
        }

        $mapel = $query->orderBy('mata_pelajarans.jenjang', 'asc')
                       ->orderBy('mata_pelajarans.kelompok', 'asc')
                       ->orderBy('mata_pelajarans.nomor_urut', 'asc')
                       ->get();

        $jurusans = DB::table('jurusans')->get();

        return view('admin.master.mata_pelajaran', compact('mapel', 'jurusans', 'autoJenjang'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_mapel' => 'required', 'jenjang' => 'required', 'kelompok' => 'required']);

        DB::table('mata_pelajarans')->insert([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'nama_ringkas' => $request->nama_ringkas,
            'kelompok' => $request->kelompok,
            'jenjang' => $request->jenjang,
            'jurusan_id' => $request->jurusan_id,
            'nomor_urut' => $request->nomor_urut ?? 100,
            'is_active' => 1,
            'created_at' => now()
        ]);

        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        // ... (Sama seperti sebelumnya) ...
        $request->validate(['id' => 'required', 'nama_mapel' => 'required']);
        DB::table('mata_pelajarans')->where('id', $request->id)->update([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'nama_ringkas' => $request->nama_ringkas,
            'kelompok' => $request->kelompok,
            'jenjang' => $request->jenjang,
            'jurusan_id' => $request->jurusan_id,
            'nomor_urut' => $request->nomor_urut,
            'is_active' => $request->is_active,
            'updated_at' => now()
        ]);
        return back()->with('success', 'Mata Pelajaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // 2. CEK KETERKAITAN DATA (GERBANG KELUAR)
        
        // Contoh: Cek Tabel Jadwal (Nanti)
        // $cekJadwal = DB::table('jadwal_pelajarans')->where('mapel_id', $id)->count();
        // if($cekJadwal > 0) return back()->with('error', 'Gagal! Mapel ini ada di jadwal pelajaran.');

        DB::table('mata_pelajarans')->delete($id);
        return back()->with('success', 'Mata Pelajaran dihapus.');
    }
}