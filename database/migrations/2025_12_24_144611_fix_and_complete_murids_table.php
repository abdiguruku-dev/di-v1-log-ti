<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // TAHAP 1: PASTIKAN SEMUA KOLOM ADA DULU (Create Missing Columns)
        Schema::table('murids', function (Blueprint $table) {
            
            // A. Status & Progress
            if (!Schema::hasColumn('murids', 'jenis_pendaftaran')) {
                $table->enum('jenis_pendaftaran', ['Siswa Baru', 'Pindahan', 'Kembali Bersekolah'])->default('Siswa Baru')->after('jurusan_id');
            }
            if (!Schema::hasColumn('murids', 'status_murid')) {
                $table->enum('status_murid', ['Aktif', 'Lulus', 'Mutasi', 'Dikeluarkan', 'Meninggal', 'Hilang'])->default('Aktif')->after('jenis_pendaftaran');
            }
            if (!Schema::hasColumn('murids', 'input_progress')) {
                $table->integer('input_progress')->default(0)->after('status_murid');
            }

            // B. Dokumen-dokumen (Sering error di sini, kita pastikan ada)
            if (!Schema::hasColumn('murids', 'file_kk')) $table->string('file_kk')->nullable()->after('foto');
            if (!Schema::hasColumn('murids', 'file_akte')) $table->string('file_akte')->nullable()->after('file_kk');
            if (!Schema::hasColumn('murids', 'file_ijazah')) $table->string('file_ijazah')->nullable()->after('file_akte');
            if (!Schema::hasColumn('murids', 'file_rapor')) $table->string('file_rapor')->nullable()->after('file_ijazah');
            if (!Schema::hasColumn('murids', 'file_surat_mutasi')) $table->string('file_surat_mutasi')->nullable()->after('file_rapor');
            if (!Schema::hasColumn('murids', 'file_surat_kematian')) $table->string('file_surat_kematian')->nullable()->after('file_surat_mutasi');
            
            // C. Bantuan & Rekening
            if (!Schema::hasColumn('murids', 'status_bantuan')) $table->string('status_bantuan')->nullable();
            if (!Schema::hasColumn('murids', 'jenis_bantuan')) $table->string('jenis_bantuan')->nullable();
            if (!Schema::hasColumn('murids', 'no_bantuan')) $table->string('no_bantuan')->nullable();
            if (!Schema::hasColumn('murids', 'file_bantuan')) $table->string('file_bantuan')->nullable();
            
            if (!Schema::hasColumn('murids', 'bantuan_sekolah')) $table->enum('bantuan_sekolah', ['Tidak', 'Ya'])->default('Tidak');
            if (!Schema::hasColumn('murids', 'ket_bantuan_sekolah')) $table->string('ket_bantuan_sekolah')->nullable();
            
            if (!Schema::hasColumn('murids', 'nama_bank')) $table->string('nama_bank')->nullable();
            if (!Schema::hasColumn('murids', 'no_rekening')) $table->string('no_rekening')->nullable();
            if (!Schema::hasColumn('murids', 'atas_nama_rekening')) $table->string('atas_nama_rekening')->nullable();
        });

        // TAHAP 2: UBAH JADI NULLABLE (Agar Draft Bisa Disimpan)
        Schema::table('murids', function (Blueprint $table) {
            // Kita bungkus try-catch biar kalau database tidak support change, tidak error fatal
            try {
                // List kolom yang harus dilonggarkan aturannya
                $columns = [
                    'nisn', 'nik', 'no_kk', 
                    'tempat_lahir', 'tanggal_lahir', 'agama', 'kewarganegaraan',
                    'alamat_jalan', 'rt', 'rw', 'desa_kelurahan', 'kecamatan', 'kabupaten_kota', 'provinsi', 'kode_pos',
                    'nama_ayah', 'nama_ibu', 'no_hp',
                    'kelas_id' // Awalnya wajib, tapi untuk draft awal mungkin belum dipilih
                ];

                foreach ($columns as $col) {
                    if (Schema::hasColumn('murids', $col)) {
                        $table->string($col)->nullable()->change();
                    }
                }
                
                // Khusus field integer/date
                if (Schema::hasColumn('murids', 'tanggal_lahir')) $table->date('tanggal_lahir')->nullable()->change();
                if (Schema::hasColumn('murids', 'kelas_id')) $table->unsignedBigInteger('kelas_id')->nullable()->change();

            } catch (\Exception $e) {
                // Abaikan error change jika driver tidak support, minimal kolomnya sudah ada.
            }
        });
    }

    public function down(): void
    {
        // Tidak perlu rollback kompleks
    }
};