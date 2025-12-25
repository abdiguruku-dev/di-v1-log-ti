<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            
            // 1. Kolom JENIS PENDAFTARAN (Masuk jalur apa?)
            if (!Schema::hasColumn('murids', 'jenis_pendaftaran')) {
                // Kita coba taruh setelah jurusan_id, kalau tidak ada taruh setelah kelas_id
                $after = Schema::hasColumn('murids', 'jurusan_id') ? 'jurusan_id' : 'kelas_id';
                
                $table->enum('jenis_pendaftaran', ['Siswa Baru', 'Pindahan', 'Kembali Bersekolah'])
                      ->default('Siswa Baru')
                      ->after($after);
            }

            // 2. Kolom STATUS MURID (Kondisi sekarang)
            if (!Schema::hasColumn('murids', 'status_murid')) {
                $table->enum('status_murid', ['Aktif', 'Lulus', 'Mutasi', 'Dikeluarkan', 'Meninggal', 'Hilang'])
                      ->default('Aktif')
                      ->after('jenis_pendaftaran');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            if (Schema::hasColumn('murids', 'jenis_pendaftaran')) {
                $table->dropColumn('jenis_pendaftaran');
            }
            if (Schema::hasColumn('murids', 'status_murid')) {
                $table->dropColumn('status_murid');
            }
        });
    }
};