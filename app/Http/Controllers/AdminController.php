<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AnalisisPrioritasController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Notifications\StatusLaporanNotification;

class AdminController extends Controller
{
    public function index()
    {
        $jumlahUser = User::where('role','masyarakat')->count();

        $jumlahLaporan = Laporan::count();

        $terkirim = Laporan::where('status','Terkirim')->count();

        $diproses = Laporan::where('status','Diproses')->count();

        $selesai = Laporan::where('status','Selesai')->count();
        $diteruskan = Laporan::where('status', 'Diteruskan')->count();
        return view('admin.dashboard-admin',compact(
            'jumlahUser',
            'jumlahLaporan',
            'terkirim',
            'diproses',
            'diteruskan',
            'selesai'
        ));
    }
    
 public function laporan(Request $request)
{
    [$query, $bulan, $tahun] =
        $this->queryLaporanTerfilter($request);

    $laporans = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.laporan', compact(
        'laporans',
        'bulan',
        'tahun'
    ));
}
    
    private function queryLaporanTerfilter(Request $request)
{
    $bulan = $request->input('bulan', now()->month);
    $tahun = $request->input('tahun', now()->year);

    $query = Laporan::with('user')
        ->whereMonth('created_at', $bulan)
        ->whereYear('created_at', $tahun);

    // Cari judul / pelapor
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('judul', 'ilike', '%' . $search . '%')
              ->orWhereHas('user', function ($user) use ($search) {

                  $user->where(
                      'name',
                      'ilike',
                      '%' . $search . '%'
                  );

              });

        });
    }

    // Filter status
    if ($request->filled('status')) {

        $query->where(
            'status',
            $request->status
        );
    }

    return [
        $query,
        $bulan,
        $tahun
    ];
}
 public function downloadLaporan(Request $request)
{
    [$query, $bulan, $tahun] =
        $this->queryLaporanTerfilter($request);

    $laporans = $query
        ->orderBy('created_at')
        ->get();

   

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

    $namaFile =
        'laporan_jalan_' .
        strtolower($namaBulan[$bulan]) .
        '_' .
        $tahun .
        '.csv';

    return response()->streamDownload(function () use ($laporans) {

        $file = fopen('php://output', 'w');

        // UTF-8 BOM supaya Excel membaca karakter dengan benar
        fwrite($file, "\xEF\xBB\xBF");

        fputcsv($file, [
            'No',
            'Tanggal',
            'Pelapor',
            'Judul Laporan',
            'Deskripsi',
            'Alamat',
            'Tipe Lokasi',
            'Latitude',
            'Longitude',
            'Status',
            'Keterangan Penanganan',
        ]);

        foreach ($laporans as $index => $laporan) {

            fputcsv($file, [
                $index + 1,
                $laporan->created_at->format('d-m-Y H:i'),
                $laporan->user->name ?? '-',
                $laporan->judul,
                $laporan->deskripsi,
                $laporan->alamat,
                ucfirst($laporan->tipe_lokasi ?? 'titik'),
                $laporan->latitude,
                $laporan->longitude,
                $laporan->status,
                $laporan->keterangan_penanganan ?? '-',
            ]);

        }

        fclose($file);

    }, $namaFile, [
        'Content-Type' => 'text/csv; charset=UTF-8',
    ]);
}
    public function detail($id)
    {
        $laporan = Laporan::with('user')->findOrFail($id);
    
        return view('admin.detail-laporan', compact('laporan'));
    }
    public function diproses($id)
    {
        $laporan = Laporan::findOrFail($id);
    
        $laporan->status = 'Diproses';
        $laporan->save();
    
        return back()->with('success','Laporan berhasil diproses.');
    }

    public function diteruskan($id)
    {
        $laporan = Laporan::findOrFail($id);
    
        $laporan->status = 'Diteruskan';
        $laporan->save();
    
        return back()->with('success','Laporan berhasil diteruskan.');
    }

    public function ditolak($id)
    {
        $laporan = Laporan::findOrFail($id);
    
        $laporan->status = 'Ditolak';
        $laporan->save();
    
        return back()->with('success','Laporan berhasil ditolak.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Terkirim,Diproses,Diteruskan,Selesai,Ditolak',
            'keterangan_penanganan' => 'nullable|string|max:1000',
        ]);
    
        $laporan = Laporan::findOrFail($id);
    
        $laporan->status = $request->status;
        $laporan->keterangan_penanganan = $request->keterangan_penanganan;
        $laporan->save();
    
        if ($laporan->status === 'Diproses') {
    
            $analisis = new AnalisisPrioritasController();
            $analisis->proses($laporan);
    
        }
        // Kirim notifikasi ke pemilik laporan
            if ($laporan->user) {
                $laporan->user->notify(
                    new StatusLaporanNotification($laporan)
                );
            }
    
        return back()->with('success', 'Status berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
    
        // Hapus foto dari storage
        if ($laporan->foto) {
            Storage::disk('public')->delete($laporan->foto);
        }
    
        // Hapus data laporan
        $laporan->delete();
    
        return redirect()
            ->route('admin.laporan')
            ->with('success', 'Laporan berhasil dihapus.');
    }
    
   public function petaPrioritas()
    {
        $laporan = Laporan::with('analisisPrioritas')
            ->select('laporans.*')
            ->selectRaw('ST_AsGeoJSON(geom_garis) AS geom_garis_geojson')
            ->where('status', 'Diproses')
            ->get();
    
        $admin = DB::selectOne("
            SELECT ST_AsGeoJSON(geom) AS geojson
            FROM admin_wonogiri
            LIMIT 1
        ");
    
        return view('admin.peta-prioritas', compact(
            'laporan',
            'admin'
        ));
    }
}