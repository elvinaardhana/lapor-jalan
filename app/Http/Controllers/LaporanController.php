<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\LaporanBaruNotification;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function create()
    {
        return view('laporan.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'judul' => 'required',
        'deskripsi' => 'required',
        'foto' => 'required|image|max:10240',

        'tipe_lokasi' => 'required|in:titik,garis',

        // Wajib jika memilih titik
        'latitude' => 'required_if:tipe_lokasi,titik|nullable|numeric',
        'longitude' => 'required_if:tipe_lokasi,titik|nullable|numeric',

        // Wajib jika memilih garis
        'garis_koordinat' => 'required_if:tipe_lokasi,garis|nullable|json',

        'alamat' => 'nullable|string',

    ], [
        'judul.required' => 'Judul laporan wajib diisi.',
        'deskripsi.required' => 'Deskripsi wajib diisi.',
        'foto.required' => 'Foto kerusakan jalan wajib dipilih.',
        'foto.image' => 'File yang dipilih harus berupa gambar.',
        'foto.max' => 'Ukuran foto maksimal 10 MB.',

        'tipe_lokasi.required' => 'Pilih bentuk lokasi kerusakan.',
        'tipe_lokasi.in' => 'Bentuk lokasi tidak valid.',

        'latitude.required_if' => 'Silakan pilih titik lokasi pada peta.',
        'longitude.required_if' => 'Silakan pilih titik lokasi pada peta.',

        'garis_koordinat.required_if' =>
            'Silakan gambar ruas kerusakan jalan pada peta.',
    ]);

    try {

        /*
        |--------------------------------------------------------------------------
        | MODE TITIK
        |--------------------------------------------------------------------------
        */
        if ($request->tipe_lokasi === 'titik') {

            // Validasi kembali di server:
            // titik harus berada di Kabupaten Wonogiri
            $cek = DB::selectOne("
                SELECT EXISTS(
                    SELECT 1
                    FROM admin_wonogiri
                    WHERE ST_Covers(
                        geom,
                        ST_SetSRID(
                            ST_MakePoint(?, ?),
                            4326
                        )
                    )
                ) AS inside
            ", [
                $request->longitude,
                $request->latitude
            ]);

            if (!$cek || !$cek->inside) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Lokasi laporan harus berada di wilayah Kabupaten Wonogiri.'
                    );
            }

            // Upload foto
            $foto = $request->file('foto')
                ->store('laporan', 'public');

            // Simpan laporan
            $laporan = Laporan::create([
                'user_id' => Auth::id(),
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'foto' => $foto,

                'tipe_lokasi' => 'titik',

                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'alamat' => $request->alamat,

                'status' => 'Terkirim',
            ]);

            // POINT asli laporan
            DB::statement("
                UPDATE laporans

                SET
                    geom = ST_SetSRID(
                        ST_MakePoint(?, ?),
                        4326
                    ),

                    geom_garis = NULL

                WHERE id = ?
            ", [
                $request->longitude,
                $request->latitude,
                $laporan->id
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | MODE GARIS
        |--------------------------------------------------------------------------
        */
        else {

            $koordinat = json_decode(
                $request->garis_koordinat,
                true
            );

            // Minimal LineString harus punya 2 titik
            if (
                !is_array($koordinat) ||
                count($koordinat) < 2
            ) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Garis kerusakan harus memiliki minimal dua titik.'
                    );
            }


            /*
             * Format GeoJSON:
             *
             * {
             *   "type": "LineString",
             *   "coordinates": [
             *      [longitude, latitude],
             *      [longitude, latitude]
             *   ]
             * }
             */
            $geojson = json_encode([
                'type' => 'LineString',
                'coordinates' => $koordinat
            ]);


            /*
             * Pastikan SELURUH garis berada
             * di wilayah Kabupaten Wonogiri.
             */
            $cekGaris = DB::selectOne("
                SELECT ST_Covers(
                    (
                        SELECT ST_UnaryUnion(
                            ST_Collect(geom)
                        )
                        FROM admin_wonogiri
                    ),

                    ST_SetSRID(
                        ST_GeomFromGeoJSON(?),
                        4326
                    )
                ) AS inside
            ", [
                $geojson
            ]);

            if (!$cekGaris || !$cekGaris->inside) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Seluruh garis kerusakan harus berada di wilayah Kabupaten Wonogiri.'
                    );
            }


            /*
             * Hitung titik representatif garis.
             *
             * Titik berada pada 50% panjang LineString.
             * Titik inilah yang dipakai untuk MCA.
             */
            $midpoint = DB::selectOne("
                WITH garis AS (

                    SELECT ST_SetSRID(
                        ST_GeomFromGeoJSON(?),
                        4326
                    ) AS geom

                )

                SELECT
                    ST_Y(
                        ST_LineInterpolatePoint(
                            geom,
                            0.5
                        )
                    ) AS latitude,

                    ST_X(
                        ST_LineInterpolatePoint(
                            geom,
                            0.5
                        )
                    ) AS longitude

                FROM garis
            ", [
                $geojson
            ]);


            // Upload foto
            $foto = $request->file('foto')
                ->store('laporan', 'public');


            /*
             * Simpan laporan.
             *
             * latitude & longitude bukan dari browser,
             * tetapi hasil midpoint PostGIS.
             */
            $laporan = Laporan::create([
                'user_id' => Auth::id(),
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'foto' => $foto,

                'tipe_lokasi' => 'garis',

                'latitude' => $midpoint->latitude,
                'longitude' => $midpoint->longitude,

                'alamat' => $request->alamat,

                'status' => 'Terkirim',
            ]);


            /*
             * geom_garis
             * = bentuk asli kerusakan
             *
             * geom
             * = midpoint untuk MCA
             */
            DB::statement("
                WITH garis AS (

                    SELECT ST_SetSRID(
                        ST_GeomFromGeoJSON(?),
                        4326
                    ) AS geom

                )

                UPDATE laporans

                SET
                    geom_garis = garis.geom,

                    geom = ST_LineInterpolatePoint(
                        garis.geom,
                        0.5
                    )

                FROM garis

                WHERE laporans.id = ?
            ", [
                $geojson,
                $laporan->id
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Notifikasi Admin
        |--------------------------------------------------------------------------
        */

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {

            $admin->notify(
                new LaporanBaruNotification($laporan)
            );
        }


        return redirect()
            ->route('laporan.create')
            ->with(
                'success',
                'Laporan berhasil dikirim.'
            );


    } catch (\Exception $e) {

        return back()
            ->withInput()
            ->with(
                'error',
                $e->getMessage()
            );
    }
}
    
    public function riwayat(Request $request)
    {
        $query = Laporan::where('user_id', Auth::id());
    
        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        $laporans = $query->latest()->get();
    
        return view('user.laporan-saya', compact('laporans'));
    }
    
  public function show($id)
{
    $laporan = Laporan::select('laporans.*')
        ->selectRaw('ST_AsGeoJSON(geom_garis) AS geom_garis_geojson')
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    return view('user.detail-laporan', compact('laporan'));
}

    public function edit(string $id)
    {

    }

    public function update(Request $request, string $id)
    {

    }

    public function destroy(string $id)
    {

    }
    public function geojsonWonogiri()
    {
        $geojson = DB::selectOne("
            SELECT json_build_object(
                'type', 'FeatureCollection',
                'features', json_agg(feature)
            ) AS geojson
            FROM (
                SELECT json_build_object(
                    'type', 'Feature',
                    'geometry', ST_AsGeoJSON(geom)::json,
                    'properties', json_build_object(
                        'id', id
                    )
                ) AS feature
                FROM admin_wonogiri
            ) feature
        ");
    
        return response()->json(json_decode($geojson->geojson));
    }
    
    public function cekWonogiri(Request $request)
    {
        $cek = DB::selectOne("
            SELECT EXISTS(
                SELECT 1
                FROM admin_wonogiri
                WHERE ST_Contains(
                    geom,
                    ST_SetSRID(
                        ST_Point(?, ?),
                        4326
                    )
                )
            ) AS inside
        ",[
            $request->longitude,
            $request->latitude
        ]);
    
        return response()->json([
            'inside' => $cek->inside
        ]);
    }
    
}