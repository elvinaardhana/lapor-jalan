@extends('layouts.admin')

@section('title','Dashboard Admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-1">
            Dashboard Admin
        </h2>

        <p class="text-muted mb-0">
            Selamat datang kembali,
            <strong>{{ Auth::user()->name }}</strong> 👋
        </p>

    </div>

    <div class="text-end">

        <div class="fw-semibold">
            {{ now()->translatedFormat('l') }}
        </div>

        <small class="text-muted">
            {{ now()->translatedFormat('d F Y') }}
        </small>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-6">

        <div class="dashboard-card bg-user">

            <div class="card-icon">

                <i class="bi bi-people-fill"></i>

            </div>

            <div>

                <h2>{{ $jumlahUser }}</h2>

                <p>Masyarakat</p>

            </div>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="dashboard-card bg-report">

            <div class="card-icon">

                <i class="bi bi-file-earmark-text-fill"></i>

            </div>

            <div>

                <h2>{{ $jumlahLaporan }}</h2>

                <p>Total Laporan</p>

            </div>

        </div>

    </div>

    <div class="col-lg-3">

<div class="dashboard-card bg-terkirim">

    <div class="card-icon">
        <i class="bi bi-send-fill"></i>
    </div>

    <div>
        <h2>{{ $terkirim }}</h2>
        <p>Terkirim</p>
    </div>

</div>

</div>


<div class="col-lg-3">

<div class="dashboard-card bg-diproses">

    <div class="card-icon">
        <i class="bi bi-hourglass-split"></i>
    </div>

    <div>
        <h2>{{ $diproses }}</h2>
        <p>Diproses</p>
    </div>

</div>

</div>


<div class="col-lg-3">

<div class="dashboard-card bg-diteruskan">

    <div class="card-icon">
        <i class="bi bi-arrow-repeat"></i>
    </div>

    <div>
        <h2>{{ $diteruskan }}</h2>
        <p>Diteruskan</p>
    </div>

</div>

</div>


<div class="col-lg-3">

<div class="dashboard-card bg-selesai">

    <div class="card-icon">
        <i class="bi bi-check-circle-fill"></i>
    </div>

    <div>
        <h2>{{ $selesai }}</h2>
        <p>Selesai</p>
    </div>

</div>

</div>

@endsection