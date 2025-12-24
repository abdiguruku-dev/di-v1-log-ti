<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel sekolah_configs
     */
    public function up(): void
    {
        Schema::create('sekolah_configs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah'); //
            $table->string('nama_aplikasi')->nullable(); //
            $table->text('alamat')->nullable(); //
            $table->string('email')->nullable(); //
            $table->string('telepon')->nullable(); //
            $table->string('website')->nullable(); //
            $table->string('jenjang')->nullable(); //
            $table->string('logo')->nullable(); //
            $table->string('mode_aplikasi')->default('TUNGGAL'); //
            $table->string('npsn')->nullable(); //
            $table->string('nss')->nullable(); //
            $table->string('akreditasi')->nullable(); //
            $table->string('kepala_sekolah')->nullable(); //
            $table->string('nip_kepsek')->nullable(); //
            $table->string('facebook')->nullable(); //
            $table->string('instagram')->nullable(); //
            $table->string('youtube')->nullable(); //
            $table->string('tiktok')->nullable(); //
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolah_configs');
    }
};