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
            // (Saya sudah hapus duplikat yang tadi ada di sini)
            'nis'           => 'required|string|max:20|unique:murids,nis',
            'nisn'          => 'nullable|string|max:20',
            'nama_lengkap'  => 'required|string|max:255',
            'kelas_id'      => 'required|exists:kelas,id',
            'jurusan_id'    => 'nullable|exists:jurusans,id',
            'jenis_kelamin' => 'required|in:L,P',
            
            // --- IDENTITAS (Dapodik) ---
            // VALIDASI NIK: Wajib isi, harus angka, pas 16 digit, unik
            'nik'           => 'required|numeric|digits:16|unique:murids,nik',
            
            // VALIDASI KK: Boleh kosong, tapi KALAU DIISI harus angka & 16 digit
            'no_kk'         => 'nullable|numeric|digits:16',

            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama'         => 'required|string',
            
            // --- ALAMAT ---
            'alamat_jalan'  => 'required|string|max:255',
            'jenis_tinggal' => 'required|in:Bersama Orang Tua,Wali,Kos,Asrama,Panti Asuhan,Lainnya',

            // --- ORANG TUA ---
            'nama_ibu'      => 'required|string|max:255',
            'nama_ayah'     => 'required|string|max:255',
            'no_hp'         => 'required|numeric', 

            // --- LOGIKA VALIDASI WALI ---
            'nama_wali'     => 'required_if:jenis_tinggal,Wali|nullable|string|max:255',
            'no_hp_wali'    => 'required_if:jenis_tinggal,Wali|nullable|numeric',
            
            // --- FILE ---
            'foto'          => 'nullable|image|max:2048',
            'file_akte'     => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk'       => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            // --- PESAN KHUSUS NIK & KK ---
            'nik.required'              => 'NIK wajib diisi sesuai KK.',
            'nik.numeric'               => 'NIK harus berupa angka (Cek jangan sampai ada huruf O).',
            'nik.digits'                => 'NIK harus berjumlah pas 16 digit.',
            'nik.unique'                => 'NIK ini sudah terdaftar di sistem.',
            
            'no_kk.numeric'             => 'No KK harus berupa angka.',
            'no_kk.digits'              => 'No KK harus berjumlah pas 16 digit.',

            // --- PESAN LAINNYA ---
            'nis.required'              => 'NIS wajib diisi.',
            'nis.unique'                => 'NIS sudah dipakai siswa lain.',
            'nama_lengkap.required'     => 'Nama Lengkap wajib diisi.',
            'jenis_tinggal.required'    => 'Pilih jenis tempat tinggal.',
            
            // Pesan Custom untuk Wali
            'nama_wali.required_if'     => 'Karena tinggal bersama Wali, Nama Wali WAJIB diisi.',
            'no_hp_wali.required_if'    => 'Nomor HP Wali wajib diisi untuk komunikasi.',
        ];
    }
}