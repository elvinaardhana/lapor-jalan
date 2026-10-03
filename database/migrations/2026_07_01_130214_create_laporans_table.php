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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('judul');
            $table->text('deskripsi');
            $table->string('foto')->nullable();

            // Koordinat
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

           
            // Status laporan
            $table->enum('status', [
                'Terkirim',
                'Diproses',
                'Selesai',
                'Ditolak',
                'Diteruskan'
            ])->default('Terkirim');

            $table->timestamps();
        });
        DB::statement("
        ALTER TABLE laporans
        ADD COLUMN geom geometry(Point,4326);
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};