<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_ajaran_id'); //
            $table->string('nama_kelas'); //
            $table->string('tingkat'); //
            $table->integer('jurusan_id')->nullable(); //
            $table->string('wali_kelas')->nullable(); //
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};