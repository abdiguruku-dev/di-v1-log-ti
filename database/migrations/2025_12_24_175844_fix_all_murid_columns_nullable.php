<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            // UBAH SEMUA KOLOM WAJIB MENJADI BOLEH KOSONG (NULLABLE)
            // Agar bisa simpan draft dari Langkah 1
            
            // 1. Data Pribadi Utama
            if (Schema::hasColumn('murids', 'nama_lengkap')) $table->string('nama_lengkap')->nullable()->change();
            if (Schema::hasColumn('murids', 'nis')) $table->string('nis')->nullable()->change();
            if (Schema::hasColumn('murids', 'jenis_kelamin')) $table->string('jenis_kelamin')->nullable()->change();
            
            // 2. Data Sekolah
            if (Schema::hasColumn('murids', 'kelas_id')) $table->unsignedBigInteger('kelas_id')->nullable()->change();
            if (Schema::hasColumn('murids', 'jurusan_id')) $table->unsignedBigInteger('jurusan_id')->nullable()->change();

            // 3. Data Tambahan (Jaga-jaga jika belum nullable)
            $cols = [
                'tempat_lahir', 'tanggal_lahir', 'agama', 'kewarganegaraan',
                'alamat_jalan', 'nama_ayah', 'nama_ibu', 'status_tinggal'
            ];

            foreach ($cols as $col) {
                if (Schema::hasColumn('murids', $col)) {
                    $table->string($col)->nullable()->change();
                }
            }
        });
    }

    public function down(): void
    {
        // Tidak perlu rollback
    }
};