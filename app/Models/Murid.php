<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit (jaga-jaga)
    protected $table = 'murids';

    // BAGIAN PENTING: Daftar kolom yang BOLEH disimpan
    // Kalau nama kolom tidak ada di sini, Laravel akan mengabaikannya (NIS & Kelas jadi kosong)
    protected $guarded = [
        'nis',
        'nisn',
        'nama_lengkap',
        'jenis_kelamin',
        'kelas_id',      // <--- Wajib ada agar kelas tersimpan
        'jurusan_id',
        'nama_ibu',
        'foto',
        'status_murid'   // Pastikan di database namanya 'status_murid' atau 'status' (sesuaikan)
    ];

    // RELASI KE KELAS (Agar bisa memanggil $murid->kelas->nama_kelas)
   public function kelas() { return $this->belongsTo(Kelas::class, 'kelas_id'); }

    // RELASI KE JURUSAN
    public function jurusan() { return $this->belongsTo(Jurusan::class, 'jurusan_id'); }
}
