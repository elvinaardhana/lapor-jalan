@extends('layouts.subpage')

@section('title','Detail Laporan')

@section('content')

<div class="d-flex align-items-center mb-4">

    <a href="{{ route('laporan.saya') }}"
        class="back-link">

        <i class="bi bi-arrow-left fs-4"></i>

    </a>

    <h4 class="fw-bold ms-2 mb-0">

        Detail Laporan

    </h4>

</div>

<img src="{{ asset('storage/'.$laporan->foto) }}"
    class="detail-img">

<h4 class="fw-bold mt-4">

    {{ $laporan->judul }}

</h4>

<span class="badge-status

@if($laporan->status=='Diproses')
warning

@elseif($laporan->status=='Terkirim')
secondary

@elseif($laporan->status=='Selesai')
success

@elseif($laporan->status=='Diteruskan')
primary

@else
danger
@endif

">

{{ $laporan->status }}

</span>

@if($laporan->keterangan_penanganan)

<div class="detail-card mt-3">

    <h6 class="fw-bold mb-2">
        <i class="bi bi-tools text-primary me-2"></i>
        Perkembangan Penanganan
    </h6>

    <p class="mb-2">
        {{ $laporan->keterangan_penanganan }}
    </p>

    <small class="text-muted">
        <i class="bi bi-clock me-1"></i>
        Diperbarui pada
        {{ $laporan->updated_at->format('d F Y, H:i') }}
    </small>

</div>

@endif
<div class="detail-card mt-4">

    <div class="mb-3">

        <small class="text-muted">

            <i class="bi bi-calendar3"></i>

            Tanggal

        </small>

        <div>

            {{ $laporan->created_at->format('d F Y') }}

        </div>

    </div>

    <div>

        <small class="text-muted">

            <i class="bi bi-geo-alt"></i>

            Lokasi

        </small>

        <div>

            {{ $laporan->alamat }}

        </div>

    </div>

</div>

<div class="detail-card mt-3">

    <h6 class="fw-bold">

        Deskripsi

    </h6>

    <p class="mb-0">

        {{ $laporan->deskripsi }}

    </p>

</div>

<div class="detail-card mt-3">

    <h6 class="fw-bold">

        Lokasi pada Peta

    </h6>

    <div id="map"></div>

</div>

@endsection


@section('scripts')

<script>

var map = L.map('map');

L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution: '&copy; OpenStreetMap'
    }
).addTo(map);


// Warna mengikuti status laporan
var statusLaporan = @json($laporan->status);

var warnaStatus = {
    'Terkirim': '#6c757d',
    'Diproses': '#f59e0b',
    'Diteruskan': '#0d6efd',
    'Selesai': '#198754',
    'Ditolak': '#dc3545'
}[statusLaporan] || '#6c757d';


@if(
    $laporan->tipe_lokasi === 'garis'
    && !empty($laporan->geom_garis_geojson)
)

    // ==========================
    // LAPORAN GARIS
    // ==========================

    var dataGaris =
        JSON.parse(@json($laporan->geom_garis_geojson));

    var garisLayer = L.geoJSON(
        dataGaris,
        {
            style: {
                color: warnaStatus,
                weight: 6,
                opacity: 0.9,
                lineCap: 'round',
                lineJoin: 'round'
            }
        }
    ).addTo(map);

    // Zoom mengikuti seluruh garis
    map.fitBounds(
        garisLayer.getBounds(),
        {
            padding: [30, 30],
            maxZoom: 17
        }
    );


@else

    // ==========================
    // LAPORAN TITIK
    // ==========================

    map.setView(
        [
            {{ $laporan->latitude }},
            {{ $laporan->longitude }}
        ],
        16
    );

    L.marker([
        {{ $laporan->latitude }},
        {{ $laporan->longitude }}
    ]).addTo(map);

@endif

</script>

@endsection