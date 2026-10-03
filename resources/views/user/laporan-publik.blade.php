@extends('layouts.mobile')

@section('title','Laporan Publik')

@section('content')

<style>

.list-laporan::-webkit-scrollbar{
    width:5px;
}

.list-laporan::-webkit-scrollbar-thumb{
    background:#d0d0d0;
    border-radius:20px;
}

.filter-card{
    border:none;
    border-radius:16px;
}

.laporan-card{
    border:none;
    border-radius:16px;
    overflow:hidden;
    transition:.2s;
}

.laporan-card:hover{
    transform:translateY(-2px);
}

.laporan-card img{
    height:190px;
    object-fit:cover;
}

.alamat{
    font-size:13px;
    color:#6c757d;
}

.deskripsi{
    color:#444;
    font-size:14px;
    line-height:1.5;
}

.status-badge{
    font-size:12px;
    padding:7px 12px;
    border-radius:20px;
}
.verification-note{
    display:flex;
    align-items:flex-start;
    gap:10px;
    padding:12px 14px;
    background:#f8f9fa;
    border:1px solid #e2e5e9;
    border-radius:12px;
    color:#6c757d;
    font-size:12px;
    line-height:1.5;
    margin-top: 7px;
}

.verification-note i{
    color:#6c757d;
    font-size:15px;
    flex-shrink:0;
    margin-top:3px;
}

.verification-note strong{
    color:#495057;
}

</style>

<div class="mb-3">

    <h3 class="fw-bold mb-1">
        <i class></i>
        Laporan Kerusakan Jalan
    </h3>
    <div class="mt-2">
    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
        <i class="bi bi-card-list me-1"></i>
        {{ $laporans->count() }} Laporan Ditampilkan
    </span>
</div>
<div class="verification-note mb-2">
    <i class="bi bi-info-circle-fill"></i>
    <span>
        Laporan berstatus <strong>Terkirim</strong> belum diverifikasi oleh admin,
        sehingga informasinya belum dapat dianggap sebagai laporan yang terverifikasi.
    </span>
</div>
</div>
<div class="card filter-card shadow-sm mb-3">

    <div class="card-body">
    <div class="fw-semibold mb-3"> <i class="bi bi-calendar3"></i> Filter Periode </div>
        <form method="GET" id="filterForm">

            @php

            $bulanList=[
                1=>'Januari',
                2=>'Februari',
                3=>'Maret',
                4=>'April',
                5=>'Mei',
                6=>'Juni',
                7=>'Juli',
                8=>'Agustus',
                9=>'September',
                10=>'Oktober',
                11=>'November',
                12=>'Desember'
            ];

            @endphp

            <div class="filter-wrapper">

                <i class="bi bi-calendar3 filter-icon"></i>

                <select
                    name="bulan"
                    class="filter-select"
                    onchange="document.getElementById('filterForm').submit()">

                    <option value="">Bulan</option>

                    @foreach($bulanList as $key=>$nama)

                    <option
                         value="{{ $key }}"
                         {{ request('bulan', now()->month) == $key ? 'selected' : '' }}>
                         {{ $nama }}
                    </option>

                    @endforeach

                </select>

                <div class="filter-divider"></div>

                <select
                    name="tahun"
                    class="filter-select"
                    onchange="document.getElementById('filterForm').submit()">

                    <option value="">Tahun</option>

                    @for($i = date('Y'); $i <= date('Y') + 3; $i++)
                    <option
                        value="{{ $i }}"
                        {{ request('tahun', now()->year) == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>

                    @endfor

                </select>

            </div>

        </form>

    </div>

</div>

@if($laporans->isEmpty())

    <div class="alert alert-info rounded-4">

        Belum ada laporan yang tersedia.

    </div>

@else

<div class="list-laporan">

@foreach($laporans as $laporan)

<a
href="{{ route('peta',[
'lat'=>$laporan->latitude,
'lng'=>$laporan->longitude,
'id'=>$laporan->id
]) }}"
class="text-decoration-none text-dark">

<div class="card laporan-card shadow-sm mb-4">

<img
src="{{ asset('storage/'.$laporan->foto) }}"
class="card-img-top">

<div class="card-body">

<div class="d-flex justify-content-between align-items-start">

<h5 class="fw-bold mb-2">

{{ $laporan->judul }}

</h5>

<i class="bi bi-chevron-right text-muted"></i>

</div>

@if($laporan->alamat)

<p class="alamat mb-2">

<i class="bi bi-geo-alt-fill text-danger"></i>

{{ \Illuminate\Support\Str::limit($laporan->alamat,70) }}

</p>

@endif

<p class="deskripsi mb-3">

{{ \Illuminate\Support\Str::limit($laporan->deskripsi,120) }}

</p>

<div class="d-flex justify-content-between align-items-center">

<span class="status-badge badge
@if($laporan->status == "Terkirim")
    bg-secondary
@elseif($laporan->status == "Diproses")
    bg-warning text-dark
@elseif($laporan->status == "Diteruskan")
    bg-primary
@elseif($laporan->status == "Selesai")
    bg-success
@endif
">

    {{ $laporan->status }}
</span>

<small class="text-muted">

<i class="bi bi-calendar-event"></i>

 {{ $laporan->created_at->format('d M Y, H:i') }} WIB

</small>

</div>

</div>

</div>

</a>

@endforeach

</div>

@endif

@endsection