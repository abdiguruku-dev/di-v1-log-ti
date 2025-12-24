<?php

namespace App\Imports;

use App\Models\Murid; // Pastikan Model Murid di-import
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // PENTING: Untuk baca baris pertama sebagai header

class MuridImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // 1. VALIDASI FORMAT HEADER (Kunci Utamanya Disini)
        // Kita cek apakah kolom WAJIB ada di file excel yang diupload.
        // Library excel otomatis mengubah "Nama Lengkap" menjadi "nama_lengkap" (snake_case/huruf kecil semua)
        
        if (!isset($row['nama_lengkap']) || !isset($row['jenis_kelamin'])) {
            // Jika kolom ini tidak ditemukan, LEMPAR ERROR KE CONTROLLER
            throw new \Exception("Format file Excel salah! Kolom 'Nama Lengkap' atau 'Jenis Kelamin' tidak ditemukan. Mohon gunakan template yang disediakan.");
        }

        // 2. Jika lolos pengecekan diatas, baru proses simpan data
        return new Murid([
            // Sesuaikan nama field Database (kiri) dengan Header Excel (kanan)
            'nama_lengkap'  => $row['nama_lengkap'], 
            'nis'           => $row['nis'] ?? null,
            'nisn'          => $row['nisn'] ?? null,
            'nik'           => $row['nik'] ?? null,
            'jenis_kelamin' => $row['jenis_kelamin'],
            'kelas_id'      => $row['kelas_id'] ?? 0, // Default 0 jika kosong
            'nama_ibu'      => $row['nama_ibu'] ?? 'Belum ada data',
            
            // Kolom wajib default lainnya
            'status_murid'  => 'Aktif',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }
}