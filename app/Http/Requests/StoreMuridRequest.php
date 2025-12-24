<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMuridRequest extends FormRequest
{
    /**
     * PENTING: Ubah jadi TRUE agar user boleh akses.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Daftar aturan validasi.
     */
    public function rules(): array
    {
        return [
            // WAJIB DIISI (Sesuai form Anda saat ini)
            'nama_lengkap'  => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P', // Hanya boleh L atau P
            'kelas_id'      => 'required|integer|exists:kelas,id', // Harus id kelas yang valid
            'nama_ibu'      => 'required|string|max:255',

            // VALIDASI TAMBAHAN (Sesuai standar ERP)
            // Agar tidak ada NISN/NIK ganda
            'nisn'          => 'nullable|numeric|unique:murids,nisn',
            'nik'           => 'nullable|numeric|digits:16|unique:murids,nik',
            'email'         => 'nullable|email|unique:murids,email',

            // Validasi File Foto
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ];
    }

    /**
     * Pesan error bahasa manusia (Indonesia).
     */
    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'kelas_id.required'     => 'Kelas wajib dipilih.',
            'nama_ibu.required'     => 'Nama Ibu Kandung wajib diisi.',
            'nisn.unique'           => 'NISN ini sudah terdaftar. Mohon cek data ganda.',
            'nik.unique'            => 'NIK ini sudah digunakan siswa lain.',
            'foto.max'              => 'Ukuran foto maksimal 2MB.',
            'foto.image'            => 'File foto harus berupa gambar.',
        ];
    }
}
