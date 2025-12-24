<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. IDENTITAS SEKOLAH
        if(DB::table('sekolah_configs')->count() == 0) {
            DB::table('sekolah_configs')->insert([
                'nama_sekolah' => 'Sekolah Juara',
                'jenjang'      => 'SMA', 
                'alamat'       => 'Jl. Pendidikan No. 1 Indonesia',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
            $this->command->info('✅ Identitas Sekolah berhasil dibuat.');
        }

        // 2. DATA KURIKULUM (Dengan Pengecekan Kolom)
        if(DB::table('kurikulums')->count() == 0) {
            $hasTahun = Schema::hasColumn('kurikulums', 'tahun_mulai');
            $dataKurikulum = [
                ['nama_kurikulum' => 'Kurikulum Merdeka', 'created_at' => now()],
                ['nama_kurikulum' => 'K-13 Revisi', 'created_at' => now()],
            ];
            if ($hasTahun) {
                $dataKurikulum[0]['tahun_mulai'] = '2025';
                $dataKurikulum[1]['tahun_mulai'] = '2025';
            }
            DB::table('kurikulums')->insert($dataKurikulum);
            $this->command->info('✅ Master Kurikulum berhasil dibuat.');
        }

        // 3. DATA JURUSAN
        if(DB::table('jurusans')->count() == 0) {
            DB::table('jurusans')->insert([
                ['kode_jurusan' => 'UMUM', 'nama_jurusan' => 'Umum', 'created_at' => now()],
                ['kode_jurusan' => 'IPA', 'nama_jurusan' => 'Ilmu Pengetahuan Alam', 'created_at' => now()],
                ['kode_jurusan' => 'IPS', 'nama_jurusan' => 'Ilmu Pengetahuan Sosial', 'created_at' => now()]
            ]);
            $this->command->info('✅ Master Jurusan berhasil dibuat.');
        }

        // ==========================================================
        // 4. DATA TAHUN AJARAN (BARU - SOLUSI ERROR ANDA)
        // ==========================================================
        // Kita wajib buat ini dulu karena 'kelas' membutuhkannya
        if(DB::table('tahun_ajarans')->count() == 0) {
            // Cek kolom apa saja yang ada di tabel tahun_ajarans biar tidak error
            $hasSemester = Schema::hasColumn('tahun_ajarans', 'semester');
            $hasStatus   = Schema::hasColumn('tahun_ajarans', 'status');
            
            $dataTahun = [
                'tahun'      => '2025/2026',
                'created_at' => now()
            ];

            // Tambahkan kolom jika ada di database
            if ($hasSemester) { $dataTahun['semester'] = 'Ganjil'; }
            if ($hasStatus)   { $dataTahun['status']   = 'Aktif'; }

            DB::table('tahun_ajarans')->insert($dataTahun);
            $this->command->info('✅ Master Tahun Ajaran berhasil dibuat.');
        }

        // ==========================================================
        // 5. DATA KELAS (DENGAN TAHUN AJARAN ID)
        // ==========================================================
        
        // Ambil ID Data Pendukung
        $jurusanUmum = DB::table('jurusans')->where('kode_jurusan', 'UMUM')->first();
        $tahunAjaran = DB::table('tahun_ajarans')->first(); // Ambil tahun ajaran yg baru dibuat
        
        // Pastikan Jurusan & Tahun Ajaran ada sebelum insert kelas
        if(DB::table('kelas')->count() == 0 && $jurusanUmum && $tahunAjaran) {
            
            $dataKelas = [
                [
                    'nama_kelas'      => 'X-1',
                    'tingkat'         => '10',
                    'jurusan_id'      => $jurusanUmum->id,
                    'tahun_ajaran_id' => $tahunAjaran->id, // <--- INI SOLUSINYA
                    'created_at'      => now()
                ],
                [
                    'nama_kelas'      => 'X-2',
                    'tingkat'         => '10',
                    'jurusan_id'      => $jurusanUmum->id,
                    'tahun_ajaran_id' => $tahunAjaran->id, // <--- INI SOLUSINYA
                    'created_at'      => now()
                ]
            ];

            // Cek Kurikulum ID (Optional, seperti kasus sebelumnya)
            if (Schema::hasColumn('kelas', 'kurikulum_id')) {
                $kurikulum = DB::table('kurikulums')->first();
                if ($kurikulum) {
                    $dataKelas[0]['kurikulum_id'] = $kurikulum->id;
                    $dataKelas[1]['kurikulum_id'] = $kurikulum->id;
                }
            }

            DB::table('kelas')->insert($dataKelas);
            $this->command->info('✅ Data Kelas Contoh berhasil dibuat.');
        }

        // 6. USER ADMIN
        if(DB::table('users')->count() == 0) {
            DB::table('users')->insert([
                'name'     => 'Administrator',
                'email'    => 'admin@sekolah.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->command->info('✅ User Admin berhasil dibuat.');
        }
    }
}