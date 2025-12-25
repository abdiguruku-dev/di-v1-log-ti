<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            
            // --- BAGIAN 1: PERBAIKAN (Restore kolom yang hilang) ---
            // Kita pastikan kolom dasar (file_kk & file_akte) ada dulu
            if (!Schema::hasColumn('murids', 'file_akte')) {
                $table->string('file_akte')->nullable()->after('foto');
            }
            if (!Schema::hasColumn('murids', 'file_kk')) {
                $table->string('file_kk')->nullable()->after('foto');
            }

            // --- BAGIAN 2: KOLOM BARU (Dokumen Pendidikan) ---
            if (!Schema::hasColumn('murids', 'file_ijazah')) {
                // Taruh setelah file_kk (jika ada) atau fallback ke foto
                $after = Schema::hasColumn('murids', 'file_kk') ? 'file_kk' : 'foto';
                $table->string('file_ijazah')->nullable()->after($after);
            }
            
            if (!Schema::hasColumn('murids', 'file_rapor')) {
                $after = Schema::hasColumn('murids', 'file_ijazah') ? 'file_ijazah' : 'foto';
                $table->string('file_rapor')->nullable()->after($after);
            }
            
            // --- BAGIAN 3: BANTUAN (KIP/KIS) ---
            // Cek apakah kolom status_bantuan sudah ada? Jika belum, buatkan.
            if (!Schema::hasColumn('murids', 'status_bantuan')) {
                $table->string('status_bantuan')->nullable()->after('foto');
            }

            if (!Schema::hasColumn('murids', 'jenis_bantuan')) {
                $table->string('jenis_bantuan')->nullable()->after('status_bantuan'); 
            }
            
            if (!Schema::hasColumn('murids', 'no_bantuan')) {
                $table->string('no_bantuan')->nullable()->after('jenis_bantuan');
            }

            if (!Schema::hasColumn('murids', 'file_bantuan')) {
                $table->string('file_bantuan')->nullable()->after('jenis_bantuan');
            }
        });
    }

    public function down(): void
    {
        // Kosongkan saja agar aman saat rollback
    }
};