<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('analisis_prioritas', function (Blueprint $table) {

            $table->double('jarak_fasum')->nullable();

            $table->string('jenis_jalan')->nullable();

            $table->string('kategori_kepadatan')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('analisis_prioritas', function (Blueprint $table) {

            $table->dropColumn([
                'jarak_fasum',
                'jenis_jalan',
                'kategori_kepadatan'
            ]);

        });
    }
};