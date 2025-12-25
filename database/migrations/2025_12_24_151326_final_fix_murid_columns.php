<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            // 1. DATA KELUARGA (Pastikan urutannya benar)
            if (!Schema::hasColumn('murids', 'jml_saudara_kandung')) $table->integer('jml_saudara_kandung')->default(0)->after('agama');
            if (!Schema::hasColumn('murids', 'jml_saudara_tiri')) $table->integer('jml_saudara_tiri')->default(0)->after('jml_saudara_kandung');
            if (!Schema::hasColumn('murids', 'jml_saudara_angkat')) $table->integer('jml_saudara_angkat')->default(0)->after('jml_saudara_tiri');

            // 2. STATUS & PROGRESS (Wajib untuk fitur Draft)
            if (!Schema::hasColumn('murids', 'input_progress')) $table->integer('input_progress')->default(0)->after('jurusan_id');
            if (!Schema::hasColumn('murids', 'status_murid')) $table->string('status_murid')->default('Aktif');
            
            // 3. UBAH KOLOM JADI BOLEH KOSONG (Agar bisa simpan draft di tengah jalan)
            // Gunakan try-catch agar tidak error jika driver tidak support
            try {
                $cols = ['nisn', 'nik', 'tempat_lahir', 'tanggal_lahir', 'nama_ayah', 'nama_ibu', 'alamat_jalan'];
                foreach($cols as $col) {
                    if (Schema::hasColumn('murids', $col)) $table->string($col)->nullable()->change();
                }
            } catch (\Exception $e) {}
        });
    }

    public function down(): void {}
};