<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMuridRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Ambil ID murid yang sedang diedit (dari input hidden 'id')
        $id = $this->id;

        return [
            // WAJIB
            'id'            => 'required|exists:murids,id', // Pastikan ID valid
            'nama_lengkap'  => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id'      => 'required|integer|exists:kelas,id',
            'nama_ibu'      => 'required|string|max:255',

            // LOGIC UNIK (PENTING: Ignore ID sendiri)
            // Artinya: Cek unik di tabel murids kolom nisn, KECUALI untuk id ini.
            'nisn'          => 'nullable|numeric|unique:murids,nisn,' . $id,
            'nis'           => 'nullable|numeric|unique:murids,nis,' . $id,
            'nik'           => 'nullable|numeric|digits:16|unique:murids,nik,' . $id,
            'email'         => 'nullable|email|unique:murids,email,' . $id,

            // FOTO (Opsional saat update)
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

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
