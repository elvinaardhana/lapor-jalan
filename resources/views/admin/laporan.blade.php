@extends('layouts.admin')

@section('title','Data Laporan')

@section('content')
@php
    $bulanList = [
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
@endphp
<div class="container-fluid">

    <div class="card shadow-sm border-0 rounded-4">

<!-- Header -->
<div class="card-header bg-white border-0 px-4 pt-4 pb-3">

    <div class="d-flex justify-content-between align-items-start">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                Data Laporan
            </h4>

            <div class="text-muted small">
                Kelola laporan kerusakan jalan yang dikirim oleh masyarakat.
            </div>

            <div class="periode-info mt-1">
                <i class="bi bi-calendar3 me-1"></i>
                Periode
                <strong>
                    {{ $bulanList[$bulan] }} {{ $tahun }}
                </strong>
            </div>
        </div>

        <div class="total-box text-center">
            <small>Total Laporan</small>
            <div class="total-number">
                {{ $laporans->total() }}
            </div>
        </div>

    </div>

</div>

<!----filter-->
<form
    method="GET"
    action="{{ route('admin.laporan') }}"
    class="px-4 py-3 border-top border-bottom bg-light bg-opacity-25">

    <div class="row g-3 align-items-end">

        {{-- Bulan --}}
        <div class="col-lg-2 col-md-3">

            <label class="form-label filter-label">
                Bulan
            </label>

            <select
                name="bulan"
                class="form-select">

                @foreach($bulanList as $key => $nama)

                    <option
                        value="{{ $key }}"
                        {{ $bulan == $key ? 'selected' : '' }}>

                        {{ $nama }}

                    </option>

                @endforeach

            </select>

        </div>


        {{-- Tahun --}}
        <div class="col-lg-2 col-md-3">

            <label class="form-label filter-label">
                Tahun
            </label>

            <select
                name="tahun"
                class="form-select">

                @for($i = now()->year; $i >= now()->year - 3; $i--)

                    <option
                        value="{{ $i }}"
                        {{ $tahun == $i ? 'selected' : '' }}>

                        {{ $i }}

                    </option>

                @endfor

            </select>

        </div>


        {{-- Status --}}
        <div class="col-lg-2 col-md-3">

            <label class="form-label filter-label">
                Status
            </label>

            <select
                name="status"
                class="form-select">

                <option value="">
                    Semua Status
                </option>

                @foreach([
                    'Terkirim',
                    'Diproses',
                    'Diteruskan',
                    'Selesai',
                    'Ditolak'
                ] as $status)

                    <option
                        value="{{ $status }}"
                        {{ request('status') == $status ? 'selected' : '' }}>

                        {{ $status }}

                    </option>

                @endforeach

            </select>

        </div>


        {{-- Pencarian --}}
        <div class="col-lg-6 col-md-12">

            <label class="form-label filter-label">
                Pencarian
            </label>

            <div class="input-group">

                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control border-start-0"
                    placeholder="Cari judul atau pelapor...">

            </div>

        </div>

    </div>


    <div class="d-flex justify-content-between align-items-center mt-3">

        <div class="d-flex gap-2">

            <button
                type="submit"
                class="btn btn-primary px-4">

                <i class="bi bi-funnel me-1"></i>
                Tampilkan

            </button>


            <a
                href="{{ route('admin.laporan') }}"
                class="btn btn-outline-secondary px-4">

                <i class="bi bi-arrow-clockwise me-1"></i>
                Reset

            </a>

        </div>


        <button
            type="submit"
            formaction="{{ route('admin.laporan.download') }}"
            formmethod="GET"
            class="btn btn-success px-4">

            <i class="bi bi-download me-1"></i>
            Unduh Laporan

        </button>

    </div>

</form>

        <!-- Isi Card -->
        <div class="card-body p-0">

            <table class="table table-hover mb-0">

                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Pelapor</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Tanggal Diperbarui</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($laporans as $laporan)

                    <tr>
                    <td>
<span class="badge rounded-circle bg-light text-dark">
{{ $laporans->firstItem() + $loop->index }}
</span>
</td>
                       

                        <td>{{ $laporan->judul }}</td>

                        <td>{{ $laporan->user->name }}</td>

                        <td>

                            @if($laporan->status=='Terkirim')
                            <span class="badge-status badge-terkirim">
    Terkirim
</span>

                            @elseif($laporan->status=='Diproses')
                                <span class="badge-status badge-proses">Diproses</span>

                            @elseif($laporan->status=='Selesai')
                                <span class="badge-status badge-selesai">Selesai</span>

                            @elseif($laporan->status=='Diteruskan')
                                <span class="badge-status badge-diteruskan">Diteruskan</span>

                            @else
                                <span class="badge-status badge-ditolak">Ditolak</span>
                            @endif

                        </td>

                        <td>{{ $laporan->created_at->format('d-m-Y') }}</td>

                        <td>{{ $laporan->updated_at->format('d-m-Y') }}</td>

        <td>
    <div class="d-flex gap-2">

        <a href="{{ route('admin.laporan.detail', $laporan->id) }}"
           class="btn btn-outline-primary btn-sm rounded-pill px-3">

            <i class="bi bi-eye"></i>
            Detail

        </a>

        <button type="button"
                class="btn btn-outline-danger btn-sm rounded-pill px-3"
                data-bs-toggle="modal"
                data-bs-target="#hapusModal{{ $laporan->id }}">

            <i class="bi bi-trash"></i>
            Hapus

        </button>

    </div>
</td>

                    </tr>

                @endforeach

                </tbody>

            </table>
            
            @foreach($laporans as $laporan)

<div class="modal fade"
     id="hapusModal{{ $laporan->id }}"
     tabindex="-1"
     aria-labelledby="hapusModalLabel{{ $laporan->id }}"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-body text-center p-4">

                <div class="hapus-icon mx-auto mb-3">

                    <i class="bi bi-trash3"></i>

                </div>

                <h5 class="fw-bold mb-2">
                    Hapus Laporan?
                </h5>

                <p class="text-muted mb-3">

                    Apakah kamu yakin ingin menghapus laporan

                    <strong class="text-dark">
                        "{{ $laporan->judul }}"
                    </strong>?

                </p>

                <div class="alert alert-warning border-0 rounded-3 text-start small mb-4">

                    <i class="bi bi-exclamation-triangle-fill me-1"></i>

                    Data laporan dan foto yang terkait akan dihapus
                    dan <strong>tidak dapat dikembalikan</strong>.

                </div>

                <div class="d-flex justify-content-center gap-2">

                    <button type="button"
                            class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">

                        Batal

                    </button>

                    <form action="{{ route('admin.laporan.destroy', $laporan->id) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger rounded-pill px-4">

                            <i class="bi bi-trash3 me-1"></i>
                            Ya, Hapus

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endforeach
            <!-- pagination -->
            <div class="card-footer bg-white">

<div class="d-flex justify-content-between align-items-center">

    <small class="text-muted">

        Menampilkan
        {{ $laporans->firstItem() }}
        -
        {{ $laporans->lastItem() }}
        dari
        {{ $laporans->total() }}
        data

    </small>

    {{ $laporans->links('pagination::bootstrap-5') }}

</div>
</div>
</div>
</div>
</div>

@endsection

