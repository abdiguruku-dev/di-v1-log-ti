<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jurusans', function (Blueprint $table) {
            // Kita tambahkan kolom jenjang setelah kolom nama_jurusan
            $table->string('jenjang')->after('nama_jurusan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('jurusans', function (Blueprint $table) {
            $table->dropColumn('jenjang');
        });
    }
};