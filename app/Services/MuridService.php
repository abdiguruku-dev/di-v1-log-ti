<?php

namespace App\Services;

use App\Models\Murid;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MuridService
{
    // 1. Helper Tahun Ajaran Otomatis
    private function getTahunAjaran()
    {
        $bulan = date('n');
        $tahun = date('Y');
        // Juli (7) ke atas masuk tahun ajaran baru
        if ($bulan > 6) {
            return $tahun . '-' . ($tahun + 1);
        } else {
            return ($tahun - 1) . '-' . $tahun;
        }
    }

    // 2. Helper Upload Sakti (Sesuai Standar Penamaan Bapak)
    private function uploadFile($file, $role, $kategori, $subKategori, $identifier, $namaUser)
    {
        if (!$file) return null;

        $tahunAjaran = $this->getTahunAjaran();
        $cleanRole = Str::studly($role); // "Murid"
        
        // Path: public/uploads/2024-2025/Murid/Dokumen/Akte
        $destinationPath = "uploads/{$tahunAjaran}/{$cleanRole}/{$kategori}";
        if ($subKategori) {
            $destinationPath .= "/{$subKategori}";
        }

        // Buat Folder jika belum ada
        if (!File::exists(public_path($destinationPath))) {
            File::makeDirectory(public_path($destinationPath), 0755, true);
        }

        // Rename File: Akte_12345_Nama-Siswa.pdf
        $cleanNama = Str::slug($namaUser);
        $prefix = $subKategori ? $subKategori : 'File';
        $extension = $file->getClientOriginalExtension();
        
        $fileName = "{$prefix}_{$identifier}_{$cleanNama}.{$extension}";

        // Pindahkan File
        $file->move(public_path($destinationPath), $fileName);

        return $destinationPath . '/' . $fileName;
    }

    public function handleStore(array $data, $files = [])
    {
        // Set Default Status
        $data['status_murid'] = 'Aktif'; 
        // Pastikan NIS Otomatis terisi jika kosong (Logic di Controller/View, ini safety net)
        
        $nis = $data['nis'];
        $nama = $data['nama_lengkap'];

        // --- PROSES UPLOAD DOKUMEN ---
        // 1. Foto Profil
        if (isset($files['foto'])) {
            $data['foto'] = $this->uploadFile($files['foto'], 'Murid', 'Foto_Profil', null, $nis, $nama);
        }
        // 2. Dokumen Kependudukan
        if (isset($files['file_kk'])) {
            $data['file_kk'] = $this->uploadFile($files['file_kk'], 'Murid', 'Dokumen', 'KK', $nis, $nama);
        }
        if (isset($files['file_akte'])) {
            $data['file_akte'] = $this->uploadFile($files['file_akte'], 'Murid', 'Dokumen', 'Akte', $nis, $nama);
        }
        // 3. Dokumen Pendidikan
        if (isset($files['file_ijazah'])) {
            $data['file_ijazah'] = $this->uploadFile($files['file_ijazah'], 'Murid', 'Dokumen', 'Ijazah', $nis, $nama);
        }
        if (isset($files['file_rapor'])) {
            $data['file_rapor'] = $this->uploadFile($files['file_rapor'], 'Murid', 'Dokumen', 'Rapor', $nis, $nama);
        }
        if (isset($files['file_surat_mutasi'])) {
            $data['file_surat_mutasi'] = $this->uploadFile($files['file_surat_mutasi'], 'Murid', 'Dokumen', 'Surat_Mutasi', $nis, $nama);
        }
        // 4. Bantuan & Lainnya
        if (isset($files['file_bantuan'])) {
            $data['file_bantuan'] = $this->uploadFile($files['file_bantuan'], 'Murid', 'Dokumen', 'Kartu_Bantuan', $nis, $nama);
        }
        if (isset($files['file_surat_kematian'])) {
            $data['file_surat_kematian'] = $this->uploadFile($files['file_surat_kematian'], 'Murid', 'Dokumen', 'Surat_Kematian', $nis, $nama);
        }

        return Murid::create($data);
    }
    
    // --- FUNGSI UPDATE DATA (EDIT) ---
    public function handleUpdate(array $data, $id, $fileFotoBaru = null)
    {
        $murid = Murid::findOrFail($id);

        // 1. Cek Upload Foto Baru
        if ($fileFotoBaru) {
            // Hapus foto lama jika ada & bukan default
            if ($murid->foto && File::exists(public_path($murid->foto))) {
                File::delete(public_path($murid->foto));
            }
            // Upload foto baru
            $data['foto'] = $this->uploadFile($fileFotoBaru, 'Murid', 'Foto_Profil', null, $murid->nis, $murid->nama_lengkap);
        }

        // Catatan: Untuk update file dokumen lain (KK, Akte, dll) via Edit, 
        // logikanya mirip. Jika di form edit ada input file lain, tambahkan di sini.
        // Saat ini di controller update hanya mengirim foto.

        // 2. Update Data ke Database
        $murid->update($data);

        return $murid;
    }

    // --- FUNGSI DELETE DATA (HAPUS) ---
    public function handleDelete($id)
    {
        $murid = Murid::find($id);

        if (!$murid) return false;

        // 1. Hapus Semua File Terkait
        $filesToDelete = [
            $murid->foto,
            $murid->file_kk,
            $murid->file_akte,
            $murid->file_ijazah,
            $murid->file_rapor,
            $murid->file_surat_mutasi,
            $murid->file_surat_kematian,
            $murid->file_bantuan
        ];

        foreach ($filesToDelete as $path) {
            if ($path && File::exists(public_path($path))) {
                File::delete(public_path($path));
            }
        }

        // 2. Hapus Data Database
        $murid->delete();

        return true;
    }
    // ... (Fungsi handleUpdate & handleDelete tetap sama, sesuaikan logic uploadnya jika perlu)
}