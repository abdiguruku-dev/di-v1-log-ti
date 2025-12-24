<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Kategori Jadwal
        Schema::create('kategori_jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jadwal'); //
            $table->boolean('is_aktif')->default(0); //
            $table->timestamps();
        });

        // Tabel Jam KBM
        Schema::create('jam_kbm', function (Blueprint $table) {
            $table->id();
            $table->integer('kategori_id'); //
            $table->integer('jam_ke'); //
            $table->time('mulai'); //
            $table->time('selesai'); //
            $table->time('mulai_jumat')->nullable(); //
            $table->time('selesai_jumat')->nullable(); //
            $table->string('keterangan')->nullable(); //
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jam_kbm');
        Schema::dropIfExists('kategori_jadwal');
    }
};