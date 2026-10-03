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
    Schema::table('laporans', function (Blueprint $table) {
        $table->text('keterangan_penanganan')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
public function down(): void
{
    if (Schema::hasColumn('laporans', 'keterangan_penanganan')) {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn('keterangan_penanganan');
        });
    }
}
};
