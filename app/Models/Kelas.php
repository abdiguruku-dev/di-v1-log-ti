<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    // Nama tabel di database
    protected $table = 'kelas';
    
    protected $guarded = [];

    // Relasi PENTING: Kelas "Milik" Jurusan
    // Fungsi inilah yang dipanggil oleh 'with("jurusan")' di Controller nanti
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}