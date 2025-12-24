<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_pelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mapel')->nullable(); //
            $table->string('nama_mapel'); //
            $table->string('nama_ringkas')->nullable(); //
            $table->string('kelompok')->nullable(); //
            $table->string('jenjang')->nullable(); //
            $table->integer('jurusan_id')->nullable(); //
            $table->integer('nomor_urut')->default(100); //
            $table->boolean('is_active')->default(1); //
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_pelajarans');
    }
};