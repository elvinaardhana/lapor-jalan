@extends('layouts.subpage')

@section('title', 'Laporan Saya')

@section('content')

<div class="d-flex align-items-center mb-4">

    <a href="{{ route('akun') }}"
       class="back-link">

        <i class="bi bi-arrow-left fs-4"></i>

    </a>

    <h4 class="fw-bold mb-0 ms-2">

        Laporan Saya

    </h4>

</div>

<form method="GET" id="filterForm" class="mb-4">
<div class="status-filter-wrapper">
    <div class="status-filter">

        <button
            type="submit"
            name="status"
            value=""
            class="status-chip {{ request('status')=='' ? 'active' : '' }}">

            Semua

        </button>

        <button
            type="submit"
            name="status"
            value="Terkirim"
            class="status-chip {{ request('status')=='Terkirim' ? 'active' : '' }}">

            Terkirim

        </button>

        <button
            type="submit"
            name="status"
            value="Diproses"
            class="status-chip {{ request('status')=='Diproses' ? 'active' : '' }}">

            Diproses

        </button>

        <button
            type="submit"
            name="status"
            value="Diteruskan"
            class="status-chip {{ request('status')=='Diteruskan' ? 'active' : '' }}">

            Diteruskan

        </button>

        <button
            type="submit"
            name="status"
            value="Selesai"
            class="status-chip {{ request('status')=='Selesai' ? 'active' : '' }}">

            Selesai

        </button>

        <button
            type="submit"
            name="status"
            value="Ditolak"
            class="status-chip {{ request('status')=='Ditolak' ? 'active' : '' }}">

        Ditolak

        </button>

    </div>
    </div>
</form>

@if($laporans->isEmpty())

<div class="text-center py-5">
    <i class="bi bi-file-earmark-text display-1 text-secondary"></i>

    @if(request('status'))
        <h5 class="mt-3 fw-bold">Tidak Ada Laporan</h5>
        <p class="text-muted">
        Coba pilih status lain untuk melihat laporan Anda.
        </p>
    @else
        <h5 class="mt-3 fw-bold">Belum Ada Laporan</h5>
        <p class="text-muted">
            Anda belum pernah membuat laporan.
        </p>
    @endif
</div>


@else

@foreach($laporans as $laporan)

<a href="{{ route('laporan.show',$laporan->id) }}"
class="laporan-card text-decoration-none text-dark">

    <img src="{{ asset('storage/'.$laporan->foto) }}"
        class="laporan-img">

    <div class="laporan-content">

        <div class="d-flex justify-content-between align-items-start gap-2">

            <h6 class="fw-bold mb-1">

                {{ $laporan->judul }}

            </h6>

            <span class="badge-status
            @if($laporan->status=='Diproses')
                warning
            @elseif($laporan->status=='Selesai')
                success
            @elseif($laporan->status=='Ditolak')
                danger
            @elseif($laporan->status=='Diteruskan')
                 primary
            @else
                secondary
            @endif">

                {{ $laporan->status }}

            </span>

        </div>

        <small class="text-muted">

            <i class="bi bi-calendar3"></i>

            {{ $laporan->created_at->format('d M Y') }}

        </small>

        <p class="laporan-deskripsi">

            {{ \Illuminate\Support\Str::limit($laporan->deskripsi,60) }}

        </p>

        <div class="text-end">

            <small class="text-primary fw-semibold">

                Lihat Detail

                <i class="bi bi-chevron-right"></i>

            </small>

        </div>

    </div>

</a>
@endforeach

@endif

@endsection
@section('scripts')

<script>

const slider = document.querySelector(".status-filter");

if(slider){

    // Kembalikan posisi scroll terakhir
    const savedScroll = sessionStorage.getItem("statusFilterScroll");

    if(savedScroll !== null){
        slider.scrollLeft = parseInt(savedScroll);
    }

    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener("mousedown",(e)=>{

        isDown = true;

        slider.classList.add("dragging");

        startX = e.pageX;

        scrollLeft = slider.scrollLeft;

    });

    document.addEventListener("mouseup",()=>{

        isDown = false;

        slider.classList.remove("dragging");

    });

    document.addEventListener("mousemove",(e)=>{

        if(!isDown) return;

        e.preventDefault();

        const walk = e.pageX - startX;

        slider.scrollLeft = scrollLeft - walk;

    });

    // Simpan posisi saat discroll
    slider.addEventListener("scroll",()=>{

        sessionStorage.setItem(
            "statusFilterScroll",
            slider.scrollLeft
        );

    });

    // Simpan posisi sebelum submit
    document.getElementById("filterForm").addEventListener("submit",()=>{

        sessionStorage.setItem(
            "statusFilterScroll",
            slider.scrollLeft
        );

    });

}

</script>

@endsection