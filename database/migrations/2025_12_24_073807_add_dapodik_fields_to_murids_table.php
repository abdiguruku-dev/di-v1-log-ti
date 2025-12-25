<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            
            // --- A. DATA PRIBADI ---
            if (!Schema::hasColumn('murids', 'nisn')) $table->string('nisn', 20)->nullable()->after('nis');
            if (!Schema::hasColumn('murids', 'nama_panggilan')) $table->string('nama_panggilan', 50)->nullable()->after('nama_lengkap');
            if (!Schema::hasColumn('murids', 'nik')) $table->string('nik', 16)->nullable()->after('nama_panggilan');
            if (!Schema::hasColumn('murids', 'no_kk')) $table->string('no_kk', 16)->nullable()->after('nik');
            
            if (!Schema::hasColumn('murids', 'tempat_lahir')) $table->string('tempat_lahir')->nullable()->after('no_kk');
            if (!Schema::hasColumn('murids', 'tanggal_lahir')) $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            if (!Schema::hasColumn('murids', 'agama')) $table->string('agama', 20)->nullable()->after('tanggal_lahir');
            
            // Detail Keluarga
            if (!Schema::hasColumn('murids', 'anak_ke')) $table->integer('anak_ke')->nullable()->after('agama');
            if (!Schema::hasColumn('murids', 'jml_saudara_kandung')) $table->integer('jml_saudara_kandung')->default(0)->after('anak_ke');
            if (!Schema::hasColumn('murids', 'jml_saudara_tiri')) $table->integer('jml_saudara_tiri')->default(0)->after('jml_saudara_kandung');
            if (!Schema::hasColumn('murids', 'jml_saudara_angkat')) $table->integer('jml_saudara_angkat')->default(0)->after('jml_saudara_tiri');
            if (!Schema::hasColumn('murids', 'status_keluarga')) $table->enum('status_keluarga', ['Anak Kandung', 'Anak Tiri', 'Anak Angkat'])->nullable()->after('jml_saudara_angkat');
            if (!Schema::hasColumn('murids', 'status_anak')) $table->enum('status_anak', ['Lengkap', 'Yatim', 'Piatu', 'Yatim Piatu'])->nullable()->after('status_keluarga');
            if (!Schema::hasColumn('murids', 'bahasa_sehari_hari')) $table->string('bahasa_sehari_hari')->nullable()->after('status_anak');

            // --- B. TEMPAT TINGGAL ---
            if (!Schema::hasColumn('murids', 'alamat_jalan')) $table->text('alamat_jalan')->nullable()->after('foto');
            if (!Schema::hasColumn('murids', 'rt')) $table->string('rt', 3)->nullable()->after('alamat_jalan');
            if (!Schema::hasColumn('murids', 'rw')) $table->string('rw', 3)->nullable()->after('rt');
            if (!Schema::hasColumn('murids', 'desa_kelurahan')) $table->string('desa_kelurahan')->nullable()->after('rw');
            if (!Schema::hasColumn('murids', 'kecamatan')) $table->string('kecamatan')->nullable()->after('desa_kelurahan');
            if (!Schema::hasColumn('murids', 'kabupaten_kota')) $table->string('kabupaten_kota')->nullable()->after('kecamatan');
            if (!Schema::hasColumn('murids', 'provinsi')) $table->string('provinsi')->nullable()->after('kabupaten_kota');
            if (!Schema::hasColumn('murids', 'kode_pos')) $table->string('kode_pos', 10)->nullable()->after('provinsi');
            
            if (!Schema::hasColumn('murids', 'no_hp')) $table->string('no_hp', 15)->nullable()->after('kode_pos');
            if (!Schema::hasColumn('murids', 'email')) $table->string('email')->nullable()->after('no_hp');
            if (!Schema::hasColumn('murids', 'status_tinggal')) $table->enum('status_tinggal', ['Bersama Orang Tua', 'Wali', 'Kos', 'Asrama', 'Panti Asuhan', 'Lainnya'])->nullable()->after('email');
            
            if (!Schema::hasColumn('murids', 'jarak_sekolah')) $table->string('jarak_sekolah')->nullable()->after('status_tinggal'); // Opsional: Bisa enum atau string (ex: "Kurang dari 1 km")
            if (!Schema::hasColumn('murids', 'transportasi')) $table->string('transportasi')->nullable()->after('jarak_sekolah');

            // --- C. KESEHATAN ---
            if (!Schema::hasColumn('murids', 'gol_darah')) $table->string('gol_darah', 5)->nullable()->after('transportasi');
            if (!Schema::hasColumn('murids', 'riwayat_penyakit')) $table->text('riwayat_penyakit')->nullable()->after('gol_darah');
            if (!Schema::hasColumn('murids', 'kelainan_jasmani')) $table->string('kelainan_jasmani')->nullable()->after('riwayat_penyakit'); // Isi string jika Ya, null jika tidak
            if (!Schema::hasColumn('murids', 'lingkar_kepala')) $table->integer('lingkar_kepala')->nullable()->after('kelainan_jasmani'); // cm
            if (!Schema::hasColumn('murids', 'tinggi_badan')) $table->integer('tinggi_badan')->nullable()->after('lingkar_kepala'); // cm
            if (!Schema::hasColumn('murids', 'berat_badan')) $table->integer('berat_badan')->nullable()->after('tinggi_badan'); // kg

            // --- D. PENDIDIKAN SEBELUMNYA ---
            if (!Schema::hasColumn('murids', 'asal_sekolah_nama')) $table->string('asal_sekolah_nama')->nullable()->after('berat_badan');
            if (!Schema::hasColumn('murids', 'asal_sekolah_npsn')) $table->string('asal_sekolah_npsn')->nullable()->after('asal_sekolah_nama');
            if (!Schema::hasColumn('murids', 'asal_sekolah_jenis')) $table->string('asal_sekolah_jenis')->nullable()->after('asal_sekolah_npsn'); // SD/MI
            if (!Schema::hasColumn('murids', 'asal_sekolah_status')) $table->string('asal_sekolah_status')->nullable()->after('asal_sekolah_jenis'); // Negeri/Swasta
            if (!Schema::hasColumn('murids', 'tgl_lulus')) $table->date('tgl_lulus')->nullable()->after('asal_sekolah_status');
            if (!Schema::hasColumn('murids', 'no_ijazah')) $table->string('no_ijazah')->nullable()->after('tgl_lulus');
            if (!Schema::hasColumn('murids', 'lama_belajar')) $table->string('lama_belajar')->nullable()->after('no_ijazah');
            if (!Schema::hasColumn('murids', 'tgl_masuk')) $table->date('tgl_masuk')->nullable(); // Tanggal masuk sekolah ini

            // --- E. DATA ORANG TUA / WALI ---
            // Ayah
            if (!Schema::hasColumn('murids', 'nama_ayah')) $table->string('nama_ayah')->nullable();
            if (!Schema::hasColumn('murids', 'nik_ayah')) $table->string('nik_ayah', 16)->nullable();
            if (!Schema::hasColumn('murids', 'tahun_lahir_ayah')) $table->string('tahun_lahir_ayah', 4)->nullable();
            if (!Schema::hasColumn('murids', 'pendidikan_ayah')) $table->string('pendidikan_ayah')->nullable();
            if (!Schema::hasColumn('murids', 'pekerjaan_ayah')) $table->string('pekerjaan_ayah')->nullable();
            if (!Schema::hasColumn('murids', 'penghasilan_ayah')) $table->string('penghasilan_ayah')->nullable();
            if (!Schema::hasColumn('murids', 'no_hp_ayah')) $table->string('no_hp_ayah')->nullable();
            if (!Schema::hasColumn('murids', 'status_ayah')) $table->string('status_ayah')->default('Hidup'); // Hidup/Meninggal
            if (!Schema::hasColumn('murids', 'tahun_meninggal_ayah')) $table->string('tahun_meninggal_ayah', 4)->nullable();

            // Ibu
            if (!Schema::hasColumn('murids', 'nama_ibu')) $table->string('nama_ibu')->nullable();
            if (!Schema::hasColumn('murids', 'nik_ibu')) $table->string('nik_ibu', 16)->nullable();
            if (!Schema::hasColumn('murids', 'tahun_lahir_ibu')) $table->string('tahun_lahir_ibu', 4)->nullable();
            if (!Schema::hasColumn('murids', 'pendidikan_ibu')) $table->string('pendidikan_ibu')->nullable();
            if (!Schema::hasColumn('murids', 'pekerjaan_ibu')) $table->string('pekerjaan_ibu')->nullable();
            if (!Schema::hasColumn('murids', 'penghasilan_ibu')) $table->string('penghasilan_ibu')->nullable();
            if (!Schema::hasColumn('murids', 'no_hp_ibu')) $table->string('no_hp_ibu')->nullable();
            if (!Schema::hasColumn('murids', 'status_ibu')) $table->string('status_ibu')->default('Hidup');
            if (!Schema::hasColumn('murids', 'tahun_meninggal_ibu')) $table->string('tahun_meninggal_ibu', 4)->nullable();

            // Wali
            if (!Schema::hasColumn('murids', 'nama_wali')) $table->string('nama_wali')->nullable();
            if (!Schema::hasColumn('murids', 'nik_wali')) $table->string('nik_wali', 16)->nullable();
            if (!Schema::hasColumn('murids', 'hubungan_wali')) $table->string('hubungan_wali')->nullable();
            if (!Schema::hasColumn('murids', 'alamat_wali')) $table->text('alamat_wali')->nullable();
            if (!Schema::hasColumn('murids', 'no_hp_wali')) $table->string('no_hp_wali')->nullable();
            if (!Schema::hasColumn('murids', 'pekerjaan_wali')) $table->string('pekerjaan_wali')->nullable();

            // --- F. HOBI & BEASISWA ---
            if (!Schema::hasColumn('murids', 'hobi_kesenian')) $table->string('hobi_kesenian')->nullable();
            if (!Schema::hasColumn('murids', 'hobi_olahraga')) $table->string('hobi_olahraga')->nullable();
            if (!Schema::hasColumn('murids', 'hobi_organisasi')) $table->string('hobi_organisasi')->nullable();
            if (!Schema::hasColumn('murids', 'hobi_lain')) $table->string('hobi_lain')->nullable();
            if (!Schema::hasColumn('murids', 'cita_cita')) $table->string('cita_cita')->nullable();
            
            if (!Schema::hasColumn('murids', 'status_bantuan')) $table->string('status_bantuan')->nullable(); // KIP/PIP/PKH
            if (!Schema::hasColumn('murids', 'no_bantuan')) $table->string('no_bantuan')->nullable();

            // --- G. FILE DOKUMEN ---
            // Catatan: 'foto' sudah ada di tabel utama
            if (!Schema::hasColumn('murids', 'file_akte')) $table->string('file_akte')->nullable();
            if (!Schema::hasColumn('murids', 'file_kk')) $table->string('file_kk')->nullable();
        });
    }

    public function down(): void
    {
        // Fitur rollback opsional, bisa dikosongkan jika tidak ingin menghapus kolom saat rollback
    }
};