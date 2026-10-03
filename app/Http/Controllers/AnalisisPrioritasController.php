<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\AnalisisPrioritas;
use Illuminate\Support\Facades\DB;

class AnalisisPrioritasController extends Controller
{
    public function proses(Laporan $laporan)
    {
        $p1 = $this->hitungP1($laporan);
        $p2 = $this->hitungP2($laporan);
        $p3 = $this->hitungP3($laporan);

        $detailFasum = $this->detailFasum($laporan);
        $detailJalan = $this->detailJalan($laporan);
        $detailKepadatan = $this->detailKepadatan($laporan);

        $total = $p1 + $p2 + $p3;
        $kategori = $this->kategoriPrioritas($total);

        AnalisisPrioritas::updateOrCreate(
            [
                'laporan_id' => $laporan->id
            ],
            [
                'p1_fasum' => $p1,
                'jarak_fasum' => $detailFasum,

                'p2_jalan' => $p2,
                'jenis_jalan' => $detailJalan,

                'p3_kepadatan' => $p3,
                'kategori_kepadatan' => $detailKepadatan,

                'skor_prioritas' => $total,
                'kategori_prioritas' => $kategori
            ]
        );
    }

    // =====================================================
    // P1 - KEDEKATAN FASILITAS UMUM
    // =====================================================

    private function hitungP1(Laporan $laporan)
    {
        $fasum = DB::selectOne("
            SELECT
                COALESCE(NULLIF(namobj, ''), remark) AS nama_fasilitas,
                remark,
                ST_Distance(
                    geom::geography,
                    ST_SetSRID(
                        ST_MakePoint(?, ?),
                        4326
                    )::geography
                ) AS jarak
            FROM fasum_wonogiri
            WHERE geom IS NOT NULL
            ORDER BY jarak
            LIMIT 1
        ", [
            $laporan->longitude,
            $laporan->latitude
        ]);

        if (!$fasum) {
            throw new \Exception(
                'Data fasilitas umum tidak ditemukan.'
            );
        }

        if ($fasum->jarak <= 100) {
            return 3;
        }

        if ($fasum->jarak <= 200) {
            return 2;
        }

        return 1;
    }

    // =====================================================
    // P2 - JENIS JALAN
    // =====================================================

    private function hitungP2(Laporan $laporan)
    {
        $jalan = DB::selectOne("
            SELECT
                remark,
                ST_Distance(
                    geom::geography,
                    ST_SetSRID(
                        ST_MakePoint(?, ?),
                        4326
                    )::geography
                ) AS jarak
            FROM jalan_wonogiri
            WHERE geom IS NOT NULL
            ORDER BY geom <-> ST_SetSRID(
                ST_MakePoint(?, ?),
                4326
            )
            LIMIT 1
        ", [
            $laporan->longitude,
            $laporan->latitude,
            $laporan->longitude,
            $laporan->latitude
        ]);

        if (!$jalan) {
            throw new \Exception(
                'Data jaringan jalan tidak ditemukan.'
            );
        }

        switch (trim($jalan->remark)) {

            case 'Jalan Kolektor':
                return 3;

            case 'Jalan Lokal':
                return 2;

            case 'Jalan Lingkungan':
                return 1;

            default:
                throw new \Exception(
                    'Jenis jalan tidak dikenali: ' . $jalan->remark
                );
        }
    }

    // =====================================================
    // P3 - KEPADATAN PENDUDUK DESA/KELURAHAN
    // =====================================================

    private function hitungP3(Laporan $laporan)
    {
        $kepadatan = DB::selectOne("
            SELECT
                kelas
            FROM kepadatan_desa
            WHERE ST_Covers(
                geom,
                ST_SetSRID(
                    ST_MakePoint(?, ?),
                    4326
                )
            )
            LIMIT 1
        ", [
            $laporan->longitude,
            $laporan->latitude
        ]);

        if (!$kepadatan) {
            throw new \Exception(
                'Lokasi laporan tidak ditemukan pada data kepadatan desa.'
            );
        }

        switch (strtolower(trim($kepadatan->kelas))) {

            case 'tinggi':
                return 3;

            case 'sedang':
                return 2;

            case 'rendah':
                return 1;

            default:
                throw new \Exception(
                    'Kategori kepadatan tidak dikenali: '
                    . $kepadatan->kelas
                );
        }
    }

    // =====================================================
    // DETAIL FASILITAS UMUM
    // =====================================================

    private function detailFasum(Laporan $laporan)
    {
        $fasum = DB::selectOne("
            SELECT
                COALESCE(NULLIF(namobj, ''), remark) AS nama_fasilitas,
                ST_Distance(
                    geom::geography,
                    ST_SetSRID(
                        ST_MakePoint(?, ?),
                        4326
                    )::geography
                ) AS jarak
            FROM fasum_wonogiri
            WHERE geom IS NOT NULL
            ORDER BY jarak
            LIMIT 1
        ", [
            $laporan->longitude,
            $laporan->latitude
        ]);

        if (!$fasum) {
            return '-';
        }

        return $fasum->nama_fasilitas
            . ' ('
            . round($fasum->jarak, 1)
            . ' m)';
    }

    // =====================================================
    // DETAIL JALAN
    // =====================================================

    private function detailJalan(Laporan $laporan)
    {
        $jalan = DB::selectOne("
            SELECT
                remark
            FROM jalan_wonogiri
            WHERE geom IS NOT NULL
            ORDER BY geom <-> ST_SetSRID(
                ST_MakePoint(?, ?),
                4326
            )
            LIMIT 1
        ", [
            $laporan->longitude,
            $laporan->latitude
        ]);

        return $jalan
            ? $jalan->remark
            : '-';
    }

    // =====================================================
    // DETAIL KEPADATAN PENDUDUK
    // =====================================================

    private function detailKepadatan(Laporan $laporan)
    {
        $kepadatan = DB::selectOne("
            SELECT
                wadmkc,
                desa_kelur,
                kepadatan_,
                kelas
            FROM kepadatan_desa
            WHERE ST_Covers(
                geom,
                ST_SetSRID(
                    ST_MakePoint(?, ?),
                    4326
                )
            )
            LIMIT 1
        ", [
            $laporan->longitude,
            $laporan->latitude
        ]);

        return $kepadatan
            ? ucfirst(strtolower(trim($kepadatan->kelas)))
            : '-';
    }

    // =====================================================
    // KATEGORI PRIORITAS
    // =====================================================

    private function kategoriPrioritas($skor)
    {
        if ($skor >= 3 && $skor <= 4) {
            return 'Rendah';
        }

        if ($skor >= 5 && $skor <= 6) {
            return 'Sedang';
        }

        if ($skor >= 7 && $skor <= 9) {
            return 'Tinggi';
        }

        throw new \Exception(
            'Skor prioritas di luar rentang 3-9: ' . $skor
        );
    }
}