@extends('layouts.admin')

@section('title','Detail Laporan')

@section('content')


@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

{{ session('success') }}

<button class="btn-close"
data-bs-dismiss="alert"></button>

</div>

@endif


<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title mb-1">

<i class="bi bi-file-earmark-text me-2"></i>

Detail Laporan

</h2>

<div class="subtitle">

Informasi lengkap laporan kerusakan jalan

</div>

</div>

<a href="{{ route('admin.laporan') }}"
class="btn btn-outline-primary rounded-pill px-4">

<i class="bi bi-arrow-left"></i>

Kembali

</a>

</div>



<div class="card section-card photo-card mb-4">

    <img
        src="{{ asset('storage/'.$laporan->foto) }}"
        alt="Foto {{ $laporan->judul }}"
        class="laporan-photo"
        data-bs-toggle="modal"
        data-bs-target="#fotoModal"
    >

</div>
<div class="row g-4">

    <!-- KIRI -->
    <div class="col-lg-6">

        <div class="row g-3">

            <div class="col-md-6">
                <div class="info-card">
                    <small>Judul Laporan</small>
                    <h6>{{ $laporan->judul }}</h6>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-card">
                    <small><i class="bi bi-person-fill me-1"></i>Pelapor</small>
                    <h6>{{ $laporan->user->name }}</h6>
                </div>
            </div>

            <div class="col-md-6">
            <div class="info-card">

<small>Status Laporan</small>

@switch($laporan->status)

    @case('Terkirim')
        <span class="badge-status badge-terkirim">
            <i class="bi bi-send me-1"></i>
            Terkirim
        </span>
    @break

    @case('Diproses')
        <span class="badge-status badge-proses">
            <i class="bi bi-hourglass-split me-1"></i>
            Diproses
        </span>
    @break

    @case('Diteruskan')
        <span class="badge-status badge-diteruskan">
            <i class="bi bi-arrow-repeat me-1"></i>
            Diteruskan
        </span>
    @break

    @case('Selesai')
        <span class="badge-status badge-selesai">
            <i class="bi bi-check-circle me-1"></i>
            Selesai
        </span>
    @break

    @case('Ditolak')
        <span class="badge-status badge-ditolak">
            <i class="bi bi-x-circle me-1"></i>
            Ditolak
        </span>
    @break

@endswitch

</div>
            </div>

            <div class="col-md-6">
                <div class="info-card">
                    <small><i class="bi bi-calendar-event me-1"></i>Tanggal</small>
                    <h6>{{ $laporan->created_at->translatedFormat('d F Y') }}</h6>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-card">
                    <small><i class="bi bi-geo-alt-fill me-1"></i>Latitude</small>
                    <h6>{{ $laporan->latitude }}</h6>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-card">
                    <small><i class="bi bi-geo-alt-fill me-1"></i>Longitude</small>
                    <h6>{{ $laporan->longitude }}</h6>
                </div>
            </div>

            <div class="col-12">
                <div class="info-card">
                    <small><i class="bi bi-geo-alt-fill me-1"></i>Alamat</small>
                    <h6 class="mb-0" style="line-height:1.6">
                        {{ $laporan->alamat }}
                    </h6>
                </div>
            </div>

        </div>

    </div>

    <!-- KANAN -->
    <div class="col-lg-6">

        <div class="card section-card h-100">

            <div class="card-body p-4">

                <h5 class="section-title mb-3">

                    <i class="bi bi-card-text me-2 text-primary"></i>

                    Deskripsi

                </h5>

                <p style="line-height:1.8">

                    {{ $laporan->deskripsi }}

                </p>

            </div>

        </div>

    </div>

</div>
<div class="card section-card mt-4">

    <div class="card-body p-4">

        <h5 class="section-title mb-4">

            <i class="bi bi-geo-alt-fill text-danger me-2"></i>

            Lokasi Laporan

        </h5>

        <div id="map"></div>

    </div>

</div>
<div class="row mt-4">
    <!-- UPDATE STATUS -->
    <div class="col-lg-4 mb-4">

        <div class="card section-card update-card">

            <div class="card-body p-4">

                <h5 class="section-title mb-4">

                    <i class="bi bi-arrow-repeat text-primary me-2"></i>

                    Update Status

                </h5>

                <form action="{{ route('admin.laporan.updateStatus',$laporan->id) }}"
                      method="POST">

                    @csrf
                    @method('PATCH')

                    <label class="form-label fw-semibold">

                        Status Laporan

                    </label>

                    <select
                        name="status"
                        class="form-select mb-4">

                        <option value="Terkirim"
                        {{ $laporan->status=='Terkirim' ? 'selected':'' }}>
                        Terkirim
                        </option>

                        <option value="Diproses"
                        {{ $laporan->status=='Diproses' ? 'selected':'' }}>
                        Diproses
                        </option>

                        <option value="Diteruskan"
                        {{ $laporan->status=='Diteruskan' ? 'selected':'' }}>
                        Diteruskan
                        </option>

                        <option value="Selesai"
                        {{ $laporan->status=='Selesai' ? 'selected':'' }}>
                        Selesai
                        </option>

                        <option value="Ditolak"
                        {{ $laporan->status=='Ditolak' ? 'selected':'' }}>
                        Ditolak
                        </option>

                    </select>
<div class="mt-3">

    <label class="form-label fw-semibold">
        Keterangan Penanganan
    </label>

   <textarea
    name="keterangan_penanganan"
    class="form-control keterangan-textarea"
    rows="4"
    maxlength="1000"
    placeholder="Contoh: Perbaikan jalan telah mencapai sekitar 30%."
>{{ old('keterangan_penanganan', $laporan->keterangan_penanganan) }}</textarea>

    <small class="text-muted">
        Berikan informasi terbaru mengenai perkembangan penanganan laporan.
    </small>

</div>
                    <button
                    class="btn btn-primary w-100 rounded-pill py-3">

                        <i class="bi bi-check-circle-fill me-2"></i>

                        Perbarui Status

                    </button>

                </form>

            </div>

        </div>

    </div>



    <!-- ANALISIS -->
    <div class="col-lg-8">

        @if($laporan->status=='Diproses')

        @if($laporan->analisisPrioritas)

        <div class="card section-card">

            <div class="card-body p-4">

                <h5 class="section-title mb-4">

                    <i class="bi bi-graph-up-arrow text-success me-2"></i>

                    Analisis Prioritas

                </h5>
                <div class="text-center mb-4">

    @php
        $warna='success';
        $icon='bi-check-circle-fill';

        if($laporan->analisisPrioritas->kategori_prioritas=='Tinggi'){
            $warna='danger';
            $icon='bi-exclamation-triangle-fill';
        }elseif($laporan->analisisPrioritas->kategori_prioritas=='Sedang'){
            $warna='warning';
            $icon='bi-exclamation-circle-fill';
        }
    @endphp

    <span class="badge bg-{{ $warna }} text-{{ $warna=='warning' ? 'dark':'white' }}
    px-4 py-3 rounded-pill fs-5">

        <i class="bi {{ $icon }} me-2"></i>

        Prioritas {{ $laporan->analisisPrioritas->kategori_prioritas }}

    </span>

</div>



<div class="row">

<div class="col-md-4 mb-3">

<div class="border rounded-4 p-4 h-100">

<small class="text-muted">

Skor Prioritas

</small>

<h1 class="display-4 fw-bold text-primary mb-0">

{{ $laporan->analisisPrioritas->skor_prioritas }}

</h1>

</div>

</div>



<div class="col-md-8 mb-3">

<div class="border rounded-4 p-4 h-100">

<small class="text-muted d-block mb-3">

Fasilitas Umum Terdekat

</small>

@php

$fasilitas=explode(',', $laporan->analisisPrioritas->jarak_fasum);

@endphp

@foreach($fasilitas as $item)

<div class="mb-2">

<i class="bi bi-geo-alt-fill text-danger me-2"></i>

{{ trim($item) }}

</div>

@endforeach

</div>

</div>



<div class="col-md-6">

<div class="border rounded-4 p-4 h-100">

<small class="text-muted">

Jenis Jalan

</small>

<h5 class="mt-2 mb-0">

{{ $laporan->analisisPrioritas->jenis_jalan }}

</h5>

</div>

</div>



<div class="col-md-6">

<div class="border rounded-4 p-4 h-100">

<small class="text-muted">

Kepadatan Penduduk

</small>

<h5 class="mt-2 mb-0">

{{ $laporan->analisisPrioritas->kategori_kepadatan }}

</h5>

</div>

</div>

</div>

</div>

</div>

@else

<div class="card section-card">

<div class="card-body text-center py-5">

<i class="bi bi-info-circle display-4 text-secondary"></i>

<h5 class="mt-3">

Analisis belum tersedia

</h5>

<p class="text-muted mb-0">

Data analisis prioritas belum dihasilkan.

</p>

</div>

</div>

@endif

@else

<div class="card section-card">

<div class="card-body text-center py-5">

<i class="bi bi-hourglass-split display-4 text-warning"></i>

<h5 class="mt-3">

Menunggu Verifikasi

</h5>

<p class="text-muted mb-0">

Analisis prioritas akan muncul setelah status laporan diubah menjadi <b>Diproses</b>.

</p>

</div>

</div>

@endif

</div>

</div>
<!-- Modal Foto -->
<div class="modal fade"
     id="fotoModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-xl">

        <div class="modal-content border-0 bg-transparent">

            <div class="modal-body p-0 text-center position-relative">

                <button
                    type="button"
                    class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

                <img
                    src="{{ asset('storage/'.$laporan->foto) }}"
                    alt="Foto {{ $laporan->judul }}"
                    class="foto-full"
                >

            </div>

        </div>

    </div>

</div>
@endsection
@section('scripts')

<script>

const lat={{ $laporan->latitude }};
const lng={{ $laporan->longitude }};
const osm = L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
    attribution:'© OpenStreetMap'
});

const satellite = L.tileLayer(
'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
{
    attribution:'Tiles © Esri'
});

const topo = L.tileLayer(
'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
{
    attribution:'© OpenTopoMap'
});

const map = L.map('map',{
    center:[lat,lng],
    zoom:16,
    layers:[osm]
});

const baseMaps = {

    "OpenStreetMap": osm,

    "Citra Satelit": satellite,

    "Topografi": topo

};

L.control.layers(baseMaps).addTo(map);

L.marker([lat,lng]).addTo(map)
.bindPopup(`
<b>{{ $laporan->judul }}</b><br>
{{ $laporan->alamat }}
`)
.openPopup();
</script>

@endsection