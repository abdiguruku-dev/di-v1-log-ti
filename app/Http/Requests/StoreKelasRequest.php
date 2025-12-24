<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelasRequest extends FormRequest
{
    /**
     * Izinkan user mengakses request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan Validasi
     */
    public function rules(): array
    {
        return [
            // Nama kelas wajib, string, maksimal 50 karakter
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas',
            
            // Tingkat wajib diisi angka
            'tingkat'    => 'required|integer',
            
            // Jurusan wajib dipilih DAN id-nya harus ada di tabel jurusans
            // Ini penting agar input hidden tidak dimanipulasi hacker
            'jurusan_id' => 'required|exists:jurusans,id',
            
            // Wali kelas opsional (boleh kosong)
            'wali_kelas' => 'nullable|string|max:100',
        ];
    }

    /**
     * Pesan Error Bahasa Indonesia
     */
    public function messages(): array
    {
        return [
            'nama_kelas.required' => 'Nama Kelas wajib diisi (Contoh: X-TKJ-1).',
            'nama_kelas.unique'   => 'Nama Kelas ini sudah ada, mohon gunakan nama lain.',
            'tingkat.required'    => 'Tingkat/Jenjang kelas wajib dipilih.',
            'jurusan_id.required' => 'Jurusan wajib dipilih.',
            'jurusan_id.exists'   => 'Jurusan tidak valid.',
        ];
    }
}