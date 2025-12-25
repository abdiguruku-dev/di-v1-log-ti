<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMuridRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // --- DATA UTAMA ---
            'nis' => 'required|unique:murids,nis',
            'nama_lengkap' => 'required',
            'kelas_id' => 'required',
            'jenis_kelamin' => 'required',
            'nis'           => 'required|string|max:20|unique:murids,nis',
            'nisn'          => 'nullable|string|max:20',
            'nama_lengkap'  => 'required|string|max:255',
            'kelas_id'      => 'required|exists:kelas,id',
            'jurusan_id'    => 'nullable|exists:jurusans,id',
            'jenis_kelamin' => 'required|in:L,P',
            
            // --- IDENTITAS (Dapodik) ---
            'nik'           => 'required|numeric|digits:16|unique:murids,nik',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required|string',
            
            // --- ALAMAT ---
            'alamat_jalan'  => 'required|string|max:255',
            'jenis_tinggal' => 'required|in:Bersama Orang Tua,Wali,Kos,Asrama,Panti Asuhan,Lainnya',

            // --- ORANG TUA ---
            'nama_ibu'      => 'required|string|max:255',
            'nama_ayah'     => 'required|string|max:255',
            'no_hp'         => 'required|numeric', // No HP Ortu/Siswa penting untuk WA Gateway nanti

            // --- LOGIKA VALIDASI WALI (The Game Changer) ---
            // "Jika Jenis Tinggal == Wali, maka Nama Wali WAJIB DIISI"
            'nama_wali'     => 'required_if:jenis_tinggal,Wali|nullable|string|max:255',
            'no_hp_wali'    => 'required_if:jenis_tinggal,Wali|nullable|numeric',
            
            // --- FILE ---
            'foto'          => 'nullable|image|max:2048',
            'file_akte' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nik.required'          => 'NIK wajib diisi sesuai KK.',
            'nik.digits'            => 'NIK harus 16 digit.',
            'nik.unique'            => 'NIK ini sudah terdaftar di sistem.',
            'jenis_tinggal.required'=> 'Pilih jenis tempat tinggal.',
            
            // Pesan Custom untuk Wali
            'nama_wali.required_if' => 'Karena tinggal bersama Wali, Nama Wali WAJIB diisi.',
            'no_hp_wali.required_if'=> 'Nomor HP Wali wajib diisi untuk komunikasi.',
        ];
    }
}