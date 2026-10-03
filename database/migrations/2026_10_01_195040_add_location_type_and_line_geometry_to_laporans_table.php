<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Menentukan apakah laporan menggunakan titik atau garis.
        // Data lama otomatis dianggap sebagai laporan titik.
        DB::statement("
            ALTER TABLE laporans
            ADD COLUMN tipe_lokasi VARCHAR(10)
            NOT NULL DEFAULT 'titik'
        ");

        // Menyimpan bentuk garis kerusakan.
        // NULL untuk laporan yang menggunakan titik.
        DB::statement("
            ALTER TABLE laporans
            ADD COLUMN geom_garis geometry(LineString, 4326)
        ");

        // Spatial index untuk mempercepat akses geometry garis.
        DB::statement("
            CREATE INDEX laporans_geom_garis_gist
            ON laporans
            USING GIST (geom_garis)
        ");
    }

    public function down(): void
    {
        DB::statement("
            DROP INDEX IF EXISTS laporans_geom_garis_gist
        ");

        DB::statement("
            ALTER TABLE laporans
            DROP COLUMN IF EXISTS geom_garis
        ");

        DB::statement("
            ALTER TABLE laporans
            DROP COLUMN IF EXISTS tipe_lokasi
        ");
    }
};