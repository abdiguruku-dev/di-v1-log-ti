<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        // 1. Buat User Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Jika sudah ada, update. Jika belum, buat baru.
            [
                'name' => 'Admin Sekolah',
                'password' => Hash::make('password123'),
                'role' => 'superadmin', //
            ]
        );

        // 2. Buat Data Sekolah Default
        DB::table('sekolah_configs')->updateOrInsert(
            ['id' => 1],
            [
                'nama_sekolah' => 'SMK Sekolah Juara', //
                'nama_aplikasi' => 'Sistem Manajemen Sekolah', //
                'mode_aplikasi' => 'TUNGGAL', //
                'created_at' => now(),
            ]
        );
    }
}