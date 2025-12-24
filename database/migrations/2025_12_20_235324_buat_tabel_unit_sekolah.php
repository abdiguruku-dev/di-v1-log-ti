<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel unit_sekolah
     */
    public function up(): void
    {
        Schema::create('unit_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_unit'); //
            $table->string('jenjang')->nullable(); //
            $table->text('alamat_unit')->nullable(); //
            $table->string('kepala_sekolah')->nullable(); //
            $table->string('nip_kepala_sekolah')->nullable(); //
            $table->string('email')->nullable(); //
            $table->string('no_telp')->nullable(); //
            $table->string('website')->nullable(); //
            $table->string('facebook')->nullable(); //
            $table->string('instagram')->nullable(); //
            $table->string('tiktok')->nullable(); //
            $table->string('youtube')->nullable(); //
            $table->string('custom_domain')->nullable(); //
            $table->string('logo')->nullable(); //
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_sekolah');
    }
};