<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; // Tambahan untuk hapus file lama

class SekolahController extends Controller
{
    // TAMPILKAN HALAMAN IDENTITAS
    public function index()
    {
        $sekolah = DB::table('sekolah_configs')->where('id', 1)->first();
        
        // Ambil Data Mode dari Session, kalau tidak ada ambil dari DB
        $mode = session('mode_aplikasi', $sekolah->mode_aplikasi ?? 'TUNGGAL');
        
        // Ambil Data Unit (Khusus Mode Terpadu)
        $units = DB::table('unit_sekolah')->get();

        return view('admin.sekolah.identitas', compact('sekolah', 'mode', 'units'));
    }

    // SIMPAN / UPDATE PROFIL UTAMA (TERMASUK LOGO & JENJANG)
    public function update(Request $request)
    {
        // 1. Ambil data config lama
        $oldConfig = DB::table('sekolah_configs')->where('id', 1)->first();

        // 2. Siapkan Data Dasar
        $data = [
            'nama_sekolah'   => $request->nama_sekolah,
            'alamat'         => $request->alamat,
            'email'          => $request->email,
            'telepon'        => $request->telepon,
            'website'        => $request->website,
            'jenjang'        => $request->jenjang, // <--- INI YANG SEBELUMNYA KURANG
            
            // Sosmed
            'facebook'       => $request->facebook,
            'instagram'      => $request->instagram,
            'youtube'        => $request->youtube,
            'tiktok'         => $request->tiktok,
            
            // Data Pimpinan
            'kepala_sekolah' => $request->kepala_sekolah,
            'nip_kepsek'     => $request->nip_kepsek, // Pastikan nama kolom di DB 'nip_kepsek' atau sesuaikan
            
            'updated_at'     => now(),
        ];

        // 3. LOGIKA UPLOAD LOGO (PERBAIKAN UTAMA)
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_utama_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Pindahkan ke folder public/uploads
            $file->move(public_path('uploads'), $filename);
            
            // Hapus logo lama jika ada (biar server tidak penuh)
            if (!empty($oldConfig->logo) && File::exists(public_path('uploads/'.$oldConfig->logo))) {
                File::delete(public_path('uploads/'.$oldConfig->logo));
            }

            // Masukkan nama file baru ke array data
            $data['logo'] = $filename;
        }

        // 4. Logika Mode Tunggal/Terpadu
        // Kita ambil mode dari session atau input hidden
        $modeSaatIni = session('mode_aplikasi', $oldConfig->mode_aplikasi);

        if ($modeSaatIni == 'TUNGGAL') {
            $data['npsn']       = $request->npsn;
            $data['nss']        = $request->nss;
            $data['akreditasi'] = $request->akreditasi;
        } else {
            // Mode Yayasan
            $data['nss']  = $request->nss; // SK Kemenkumham
            $data['npsn'] = '-'; 
        }

        // 5. Eksekusi Update
        DB::table('sekolah_configs')->where('id', 1)->update($data);

        return back()->with('success', 'Profil Sekolah, Logo, dan Jenjang berhasil diperbarui!');
    }

    // GANTI MODE APLIKASI
    public function switchMode(Request $request)
    {
        // Simpan ke Database
        DB::table('sekolah_configs')->where('id', 1)->update([
            'mode_aplikasi' => $request->mode
        ]);

        // Simpan ke Session agar aplikasi tahu
        session(['mode_aplikasi' => $request->mode]);

        return back()->with('success', 'Mode Aplikasi berhasil diubah menjadi ' . $request->mode);
    }

    // --- FITUR UNIT SEKOLAH (MODE TERPADU) ---

    // MENAMPILKAN DAFTAR SEMUA UNIT (YAYASAN)
    public function unitIndex()
    {
        // 1. Ambil semua data dari tabel unit_sekolah
        $units = DB::table('unit_sekolah')->get();

        // 2. Kirim ke View (Tampilan)
        // Pastikan file: resources/views/admin/sekolah/unit/index.blade.php sudah dibuat
        return view('admin.sekolah.unit.index', compact('units'));
    }

    public function storeUnit(Request $request)
    {
        $data = [
            'nama_unit'      => $request->nama_unit,
            'jenjang'        => $request->jenjang,
            'alamat_unit'    => $request->alamat_unit,
            'kepala_sekolah' => $request->kepala_sekolah,
            'nip_kepala_sekolah' => $request->nip_kepala_sekolah,
            'email'          => $request->email,
            'no_telp'        => $request->no_telp,
            'website'        => $request->website,
            'facebook'       => $request->facebook,
            'instagram'      => $request->instagram,
            'tiktok'         => $request->tiktok,
            'youtube'        => $request->youtube,
            'custom_domain'  => $request->custom_domain,
            'created_at'     => now()
        ];

        // Upload Logo Unit (Jika Ada)
        if ($request->hasFile('logo_unit')) {
            $file = $request->file('logo_unit');
            $filename = 'logo_unit_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $data['logo'] = $filename;
        }

        DB::table('unit_sekolah')->insert($data);
        return back()->with('success', 'Unit Sekolah berhasil ditambahkan!');
    }

    public function updateUnit(Request $request)
    {
        $unit = DB::table('unit_sekolah')->where('id', $request->id)->first();

        $data = [
            'nama_unit'      => $request->nama_unit,
            'jenjang'        => $request->jenjang,
            'alamat_unit'    => $request->alamat_unit,
            'kepala_sekolah' => $request->kepala_sekolah,
            'nip_kepala_sekolah' => $request->nip_kepala_sekolah,
            'email'          => $request->email,
            'no_telp'        => $request->no_telp,
            'website'        => $request->website,
            'facebook'       => $request->facebook,
            'instagram'      => $request->instagram,
            'tiktok'         => $request->tiktok,
            'youtube'        => $request->youtube,
            'custom_domain'  => $request->custom_domain,
            'updated_at'     => now()
        ];

        // Update Logo Unit (Jika Ada File Baru)
        if ($request->hasFile('logo_unit')) {
            $file = $request->file('logo_unit');
            $filename = 'logo_unit_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            
            // Hapus logo lama unit jika ada
            if(!empty($unit->logo) && File::exists(public_path('uploads/'.$unit->logo))){
                File::delete(public_path('uploads/'.$unit->logo));
            }

            $data['logo'] = $filename;
        }

        DB::table('unit_sekolah')->where('id', $request->id)->update($data);
        return back()->with('success', 'Data Unit Sekolah berhasil diperbarui!');
    }

    public function destroyUnit($id)
    {
        $unit = DB::table('unit_sekolah')->where('id', $id)->first();
        
        // Hapus file logo jika ada
        if(!empty($unit->logo) && File::exists(public_path('uploads/'.$unit->logo))){
            File::delete(public_path('uploads/'.$unit->logo));
        }

        DB::table('unit_sekolah')->where('id', $id)->delete();
        return back()->with('success', 'Unit Sekolah berhasil dihapus!');
    }
}