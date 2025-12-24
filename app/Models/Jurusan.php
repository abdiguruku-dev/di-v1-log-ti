<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    // Beritahu Laravel nama tabelnya (karena bahasa Indonesia)
    protected $table = 'jurusans';
    
    // Izinkan semua kolom diisi (mass assignment)
    protected $guarded = [];

    // Relasi: Satu Jurusan punya banyak Kelas
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }
}