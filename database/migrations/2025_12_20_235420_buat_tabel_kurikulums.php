<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulums', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kurikulum'); //
            $table->integer('tahun_mulai'); //
            $table->string('label_periode')->default('Semester'); //
            $table->integer('jumlah_periode')->default(2); //
            $table->string('skala_nilai')->nullable(); //
            $table->text('keterangan')->nullable(); //
            $table->string('dokumen_pendukung')->nullable(); //
            $table->boolean('is_active')->default(1); //
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulums');
    }
};