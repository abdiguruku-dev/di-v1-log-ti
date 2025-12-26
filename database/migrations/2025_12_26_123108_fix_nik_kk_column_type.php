<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('murids', function (Blueprint $table) {
            // Ubah NIK dan KK jadi Teks (VARCHAR) panjang 25 karakter
            // Agar muat 16 digit dan nol di depan tidak hilang
            $table->string('nik', 25)->change();
            $table->string('no_kk', 25)->nullable()->change();
            
            // Jaga-jaga sekalian No HP dan NISN biar aman
            $table->string('no_hp', 20)->nullable()->change();
            $table->string('nisn', 20)->nullable()->change();
        });
    }

    public function down()
    {
        // Ini perintah untuk membatalkan (Rollback) - Kembalikan ke Integer
        Schema::table('murids', function (Blueprint $table) {
            $table->integer('nik')->change();
            $table->integer('no_kk')->change();
        });
    }
};