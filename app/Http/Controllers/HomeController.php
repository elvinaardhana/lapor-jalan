<?php

namespace App\Http\Controllers;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        $bulan = now()->month;
        $tahun = now()->year;

        $terkirim = Laporan::where('status', 'Terkirim')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();

        $diproses = Laporan::whereIn('status', [
            'Diproses',
            'Diteruskan'
        ])
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();

        $selesai = Laporan::where('status', 'Selesai')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->count();

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $periode = $namaBulan[$bulan] . ' ' . $tahun;

        return view('user.dashboard', compact(
            'terkirim',
            'diproses',
            'selesai',
            'periode'
        ));
    }
   public function peta(Request $request)
    {
        $query = Laporan::select('laporans.*')
            ->selectRaw('ST_AsGeoJSON(geom_garis) AS geom_garis_geojson')
            ->whereIn('status', [
                'Terkirim',
                'Diproses',
                'Diteruskan',
                'Selesai'
            ]);
    
        // Jika membuka dari Laporan Publik
        if ($request->filled('id')) {
    
            // Tampilkan hanya laporan yang dipilih
            $query->where('id', $request->id);
    
        } else {
    
            // Jika tidak ada filter,
            // otomatis gunakan bulan dan tahun sekarang
            $bulan = $request->input('bulan', now()->month);
            $tahun = $request->input('tahun', now()->year);
    
            $query->whereMonth('created_at', $bulan)
                  ->whereYear('created_at', $tahun);
        }
    
        $laporans = $query->latest()->get();
    
        $admin = DB::selectOne("
            SELECT ST_AsGeoJSON(geom) AS geojson
            FROM admin_wonogiri
            LIMIT 1
        ");
    
        return view('user.peta', [
            'laporans' => $laporans,
            'lat'      => $request->lat,
            'lng'      => $request->lng,
            'id'       => $request->id,
            'admin'    => $admin,
        ]);
    }
    public function laporanPublik(Request $request)
    {
        $laporans = Laporan::whereIn('status', [
            'Terkirim',
            'Diproses',
            'Diteruskan',
            'Selesai'
        ]);
    
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;
        
        $laporans->whereMonth('created_at', $bulan)
                 ->whereYear('created_at', $tahun);
    
        $laporans = $laporans
            ->latest()
            ->get();
    
        return view('user.laporan-publik', compact('laporans'));
    }
    
    public function akun()
    {
        if (!Auth::check()) {
            return view('user.akun');
        }
    
        $user = Auth::user();
    
        $jumlahLaporan = Laporan::where('user_id', $user->id)->count();
    
        $terkirim = Laporan::where('user_id', $user->id)
            ->where('status','Terkirim')
            ->count();
    
        $diproses = Laporan::where('user_id', $user->id)
            ->where('status','Diproses')
            ->count();
    
        $diteruskan = Laporan::where('user_id', $user->id)
            ->where('status','Diteruskan')
            ->count();
    
        $selesai = Laporan::where('user_id', $user->id)
            ->where('status','Selesai')
            ->count();
    
        $ditolak = Laporan::where('user_id', $user->id)
            ->where('status','Ditolak')
            ->count();
    
        return view('user.akun', compact(
            'jumlahLaporan',
            'terkirim',
            'diproses',
            'diteruskan',
            'selesai',
            'ditolak'
        ));
    }

}