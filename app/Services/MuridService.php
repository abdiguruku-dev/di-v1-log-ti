<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MuridService
{
    /**
     * TUGAS 1: MENANGANI SIMPAN DATA BARU
     * Menerima data array (dari form) dan file foto (opsional)
     */
    public function handleStore(array $data, $fileFoto = null)
    {
        // 1. Cek apakah ada foto yang diupload?
        $namaFoto = null;
        if ($fileFoto) {
            // Panggil fungsi pembantu 'uploadFoto' di bawah
            $namaFoto = $this->uploadFoto($fileFoto);
        }

        // 2. Gabungkan data form dengan nama foto baru
        $dataSimpan = array_merge($data, [
            'foto'          => $namaFoto,
            'status_murid'  => 'Aktif',
            'created_at'    => now()
        ]);

        // 3. Masukkan ke Database
        return DB::table('murids')->insert($dataSimpan);
    }

    /**
     * TUGAS 2: MENANGANI UPDATE DATA
     */
    public function handleUpdate(array $data, $id, $fileFoto = null)
    {
        // 1. Ambil data murid lama (untuk mengecek foto lamanya)
        $muridLama = DB::table('murids')->where('id', $id)->first();
        
        // Default nama foto pakai yang lama dulu
        $namaFoto = $muridLama->foto;

        // 2. Jika user upload foto baru
        if ($fileFoto) {
            // Hapus foto lama dari folder (Panggil fungsi pembantu)
            $this->hapusFotoFisik($muridLama->foto);
            
            // Upload foto baru
            $namaFoto = $this->uploadFoto($fileFoto);
        }

        // 3. Gabungkan data update
        $dataUpdate = array_merge($data, [
            'foto'       => $namaFoto,
            'updated_at' => now()
        ]);

        // 4. Update Database
        return DB::table('murids')->where('id', $id)->update($dataUpdate);
    }

    /**
     * TUGAS 3: MENANGANI HAPUS DATA
     */
    public function handleDelete($id)
    {
        $murid = DB::table('murids')->where('id', $id)->first();

        if ($murid) {
            // 1. Bersihkan dulu fotonya dari folder komputer
            $this->hapusFotoFisik($murid->foto);

            // 2. Baru hapus datanya dari database
            return DB::table('murids')->where('id', $id)->delete();
        }

        return false; // Jika data tidak ditemukan
    }

    // ==========================================================
    // FUNGSI PEMBANTU (PRIVATE)
    // Hanya bisa dipanggil oleh fungsi di dalam file ini saja.
    // ==========================================================

    private function uploadFoto($file)
    {
        // Buat nama unik: waktu_namafileasli.jpg
        $namaFoto = time() . '_' . $file->getClientOriginalName();
        // Pindahkan file ke public/uploads/murid
        $file->move(public_path('uploads/murid'), $namaFoto);
        
        return $namaFoto;
    }

    private function hapusFotoFisik($namaFoto)
    {
        // Cek apakah ada nama fotonya DAN apakah filenya ada di folder?
        if ($namaFoto && file_exists(public_path('uploads/murid/' . $namaFoto))) {
            unlink(public_path('uploads/murid/' . $namaFoto)); // Hapus file
        }
    }
}