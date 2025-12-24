<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('murids', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap'); //
            $table->string('nis')->nullable(); //
            $table->string('nisn')->nullable(); //
            $table->string('nik')->nullable(); //
            $table->string('no_kk')->nullable(); //
            $table->string('jenis_kelamin'); //
            $table->string('tempat_lahir')->nullable(); //
            $table->date('tanggal_lahir')->nullable(); //
            $table->string('agama')->nullable(); //
            $table->integer('anak_ke')->nullable(); //
            $table->integer('kelas_id'); //
            $table->integer('jurusan_id')->nullable(); //
            $table->date('tanggal_masuk')->nullable(); //
            $table->string('asal_sekolah')->nullable(); //
            $table->string('status_murid')->default('Aktif'); //
            $table->string('nama_ayah')->nullable(); //
            $table->string('pekerjaan_ayah')->nullable(); //
            $table->string('nama_ibu')->nullable(); //
            $table->string('pekerjaan_ibu')->nullable(); //
            $table->string('nama_wali')->nullable(); //
            $table->string('no_hp_ortu')->nullable(); //
            $table->text('alamat_jalan')->nullable(); //
            $table->string('rt')->nullable(); //
            $table->string('rw')->nullable(); //
            $table->string('desa_kelurahan')->nullable(); //
            $table->string('kecamatan')->nullable(); //
            $table->string('kabupaten_kota')->nullable(); //
            $table->string('no_hp_murid')->nullable(); //
            $table->string('foto')->nullable(); //
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('murids');
    }
};