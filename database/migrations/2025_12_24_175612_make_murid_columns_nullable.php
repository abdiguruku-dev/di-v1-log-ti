<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            // KITA UBAH SEMUA KOLOM ANGKA AGAR BOLEH KOSONG (NULLABLE)
            // Ini wajib untuk fitur Save Draft
            
            $angkaCols = [
                'jml_saudara_kandung', 'jml_saudara_tiri', 'jml_saudara_angkat', 
                'anak_ke', 'rt', 'rw', 'kode_pos', 
                'nik', 'nik_ayah', 'nik_ibu', 
                'penghasilan_ayah', 'penghasilan_ibu', 
                'tinggi_badan', 'berat_badan', 'lingkar_kepala'
            ];

            foreach ($angkaCols as $col) {
                if (Schema::hasColumn('murids', $col)) {
                    // Ubah jadi nullable dan default NULL
                    $table->integer($col)->nullable()->default(null)->change();
                }
            }

            // UBAH KOLOM TEKS JUGA (JAGA-JAGA)
            $textCols = [
                'tempat_lahir', 'no_hp', 'email', 'alamat_jalan', 
                'nama_ayah', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu'
            ];

            foreach ($textCols as $col) {
                if (Schema::hasColumn('murids', $col)) {
                    $table->string($col)->nullable()->default(null)->change();
                }
            }
        });
    }

    public function down(): void
    {
        // Tidak perlu rollback khusus
    }
};