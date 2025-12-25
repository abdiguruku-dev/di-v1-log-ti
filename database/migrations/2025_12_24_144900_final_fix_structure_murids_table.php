<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            
            // 1. DATA KELUARGA (Penyebab Error Tadi)
            // Cek: Apakah kolom saudara kandung ada? Jika tidak, buat dulu.
            if (!Schema::hasColumn('murids', 'jml_saudara_kandung')) {
                $table->integer('jml_saudara_kandung')->default(0)->after('agama'); // Sesuaikan posisi aman
            }
            // Sekarang aman untuk membuat saudara tiri
            if (!Schema::hasColumn('murids', 'jml_saudara_tiri')) {
                $table->integer('jml_saudara_tiri')->default(0)->after('jml_saudara_kandung');
            }
            if (!Schema::hasColumn('murids', 'jml_saudara_angkat')) {
                $table->integer('jml_saudara_angkat')->default(0)->after('jml_saudara_tiri');
            }

            // 2. STATUS & PROGRESS (Untuk Fitur Draft)
            if (!Schema::hasColumn('murids', 'jenis_pendaftaran')) {
                $table->enum('jenis_pendaftaran', ['Siswa Baru', 'Pindahan', 'Kembali Bersekolah'])->default('Siswa Baru')->after('jurusan_id');
            }
            if (!Schema::hasColumn('murids', 'status_murid')) {
                $table->enum('status_murid', ['Aktif', 'Lulus', 'Mutasi', 'Dikeluarkan', 'Meninggal', 'Hilang'])->default('Aktif')->after('jenis_pendaftaran');
            }
            if (!Schema::hasColumn('murids', 'input_progress')) {
                $table->integer('input_progress')->default(0)->after('status_murid');
            }

            // 3. SEMUA KOLOM LAINNYA (Cek satu per satu)
            $columns = [
                'kewarganegaraan' => ['enum', ['WNI', 'WNA'], 'WNI'],
                'status_anak' => ['enum', ['Lengkap', 'Yatim', 'Piatu', 'Yatim Piatu'], 'Lengkap'],
                'bahasa_sehari_hari' => ['string', null, null],
                'berkebutuhan_khusus' => ['enum', ['Tidak', 'Ya'], 'Tidak'],
                'ket_berkebutuhan_khusus' => ['string', null, null],
                'pekerjaan_wali' => ['string', null, null],
                'bantuan_sekolah' => ['enum', ['Tidak', 'Ya'], 'Tidak'],
                'ket_bantuan_sekolah' => ['string', null, null],
                'nama_bank' => ['string', null, null],
                'no_rekening' => ['string', null, null],
                'atas_nama_rekening' => ['string', null, null],
                // File Uploads
                'file_kk' => ['string', null, null],
                'file_akte' => ['string', null, null],
                'file_ijazah' => ['string', null, null],
                'file_rapor' => ['string', null, null],
                'file_surat_mutasi' => ['string', null, null],
                'file_surat_kematian' => ['string', null, null],
                'file_bantuan' => ['string', null, null],
                'status_bantuan' => ['string', null, null],
                'jenis_bantuan' => ['string', null, null],
                'no_bantuan' => ['string', null, null],
            ];

            foreach ($columns as $name => $specs) {
                if (!Schema::hasColumn('murids', $name)) {
                    if ($specs[0] == 'enum') {
                        $table->enum($name, $specs[1])->default($specs[2]);
                    } elseif ($specs[0] == 'integer') {
                        $table->integer($name)->default($specs[2]);
                    } else {
                        $table->string($name)->nullable();
                    }
                }
            }
        });

        // 4. UBAH JADI NULLABLE (Agar Draft Bisa Jalan)
        // Kita pakai try-catch agar aman jika driver DB tidak support change
        try {
            Schema::table('murids', function (Blueprint $table) {
                $nullableCols = [
                    'nisn', 'nik', 'no_kk', 'tempat_lahir', 'tanggal_lahir', 'agama', 
                    'alamat_jalan', 'nama_ayah', 'nama_ibu', 'no_hp', 'kelas_id'
                ];
                foreach ($nullableCols as $col) {
                    if (Schema::hasColumn('murids', $col)) {
                        $table->string($col)->nullable()->change();
                    }
                }
                // Khusus Date & Int
                if (Schema::hasColumn('murids', 'tanggal_lahir')) $table->date('tanggal_lahir')->nullable()->change();
                if (Schema::hasColumn('murids', 'kelas_id')) $table->unsignedBigInteger('kelas_id')->nullable()->change();
            });
        } catch (\Exception $e) {
            // Abaikan jika gagal change, yang penting kolomnya ada.
        }
    }

    public function down(): void
    {
        // Safety
    }
};