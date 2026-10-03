<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analisis_prioritas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('laporan_id')
                ->constrained('laporans')
                ->cascadeOnDelete();

            $table->integer('p1_fasum');

            $table->integer('p2_jalan');

            $table->integer('p3_kepadatan');

            $table->integer('skor_prioritas');

            $table->string('kategori_prioritas', 20);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis_prioritas');
    }
};