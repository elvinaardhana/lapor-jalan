@extends('layouts.mobile')

@section('title','Dashboard')


@section('content')

<div class="dashboard">

    {{-- Banner --}}
    <div class="hero-card mb-4">

        <div class="d-flex align-items-center">

            <img src="{{ asset('images/Logo putih.png') }}" class="hero-logo">

            <div class="ms-4">

                <h4 class="mb-2 fw-bold text-white">
                    Lapor Kerusakan Jalan Kabupaten Wonogiri
                </h4>

                <p class="mb-0 text-white-50">
                    Aplikasi ini digunakan untuk melaporkan kerusakan jalan yang ada di Kabupaten Wonogiri
                </p>

            </div>

        </div>

    </div>

    {{-- Statistik --}}
    <div class="card shadow-sm rounded-4 border-0 mb-4">

        <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

<h6 class="fw-bold mb-0">
    Statistik Laporan
</h6>

<small class="periode-bulan">
    {{ $periode }}
</small>

</div>
            <div class="row text-center">

                <div class="col-4">

                    <div class="stat-box red">

                        <small>Terkirim</small>

                        <h3 class="counter" data-target="{{ $terkirim }}">0</h3>
                    </div>

                </div>

                <div class="col-4">

                    <div class="stat-box orange">

                        <small>Sedang Diproses</small>

                        <h3 class="counter" data-target="{{ $diproses }}">0</h3>
                    </div>

                </div>

                <div class="col-4">

                    <div class="stat-box green">

                        <small>Selesai</small>

                        <h3 class="counter" data-target="{{ $selesai }}">0</h3>
                    </div>

                </div>

            </div>

        </div>

    </div>
<div class="card shadow-sm rounded-4 border-0 mb-4">

    <div class="card-body">

        <button
            class="btn w-100 d-flex justify-content-between align-items-center p-0 border-0 bg-transparent"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#infoStatus"
            aria-expanded="false"
            aria-controls="infoStatus">

            <div class="fw-bold">
                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                Informasi Status Laporan
            </div>

            <i class="bi bi-chevron-down status-chevron"></i>

        </button>


        <div class="collapse mt-3" id="infoStatus">

            <div class="status-info-item">

                <span class="status-dot status-terkirim">
                    <i class="bi bi-send-fill"></i>
                </span>

                <div>
                    <div class="fw-semibold">
                        Terkirim
                    </div>

                    <small class="text-muted">
                        Laporan telah berhasil dikirim dan menunggu pemeriksaan administrator.
                    </small>
                </div>

            </div>


            <div class="status-divider"></div>


            <div class="status-info-item">

                <span class="status-dot status-diproses">
                    <i class="bi bi-hourglass-split"></i>
                </span>

                <div>
                    <div class="fw-semibold">
                        Diproses
                    </div>

                    <small class="text-muted">
                        Laporan telah diperiksa dan sedang dalam tahap pemrosesan.
                    </small>
                </div>

            </div>


            <div class="status-divider"></div>


            <div class="status-info-item">

                <span class="status-dot status-diteruskan">
                    <i class="bi bi-arrow-right-circle-fill"></i>
                </span>

                <div>
                    <div class="fw-semibold">
                        Diteruskan
                    </div>

                    <small class="text-muted">
                        Laporan telah diteruskan kepada pihak terkait untuk penanganan lebih lanjut.
                    </small>
                </div>

            </div>


            <div class="status-divider"></div>


            <div class="status-info-item">

                <span class="status-dot status-selesai">
                    <i class="bi bi-check-circle-fill"></i>
                </span>

                <div>
                    <div class="fw-semibold">
                        Selesai
                    </div>

                    <small class="text-muted">
                        Proses penanganan laporan telah dinyatakan selesai.
                    </small>
                </div>

            </div>


            <div class="status-divider"></div>


            <div class="status-info-item">

                <span class="status-dot status-ditolak">
                    <i class="bi bi-x-circle-fill"></i>
                </span>

                <div>
                    <div class="fw-semibold">
                        Ditolak
                    </div>

                    <small class="text-muted">
                        Laporan tidak dapat diproses. Alasan penolakan dapat dilihat pada detail laporan.
                    </small>
                </div>

            </div>

        </div>

    </div>

</div>
    {{-- Tombol --}}
    <a href="{{ route('laporan.create') }}" class="btn-lapor">

<div class="btn-icon">
    <i class="bi bi-plus-lg"></i>
</div>

<div class="flex-grow-1">

    <div class="btn-title">
        Buat Laporan Baru
    </div>

    <div class="btn-subtitle">
        Kirim foto & lokasi kerusakan jalan
    </div>

</div>

</a>

    {{-- Menu --}}
    <a href="{{ route('laporan.publik') }}" class="menu-card mb-3">

        <span>Lihat laporan terkirim</span>

        <i class="bi bi-chevron-right"></i>

    </a>
<!-- tips -->
{{-- Tips --}}
    <div class="tips-card">

<div class="tips-icon">

    <i class="bi bi-lightbulb-fill"></i>

</div>

<div>

    <div class="tips-title">

        Tips Melaporkan

    </div>

    <div class="tips-desc">

        Ambil foto dari jarak dekat agar kerusakan terlihat jelas
        *Aktifkan GPS untuk mendapatkan lokasi saat ini 

    </div>

</div>

</div>

    {{-- FAQ --}}
    {{-- FAQ --}}
<div class="card shadow-sm rounded-4 border-0 mb-4">

    <div class="card-body">

        <h6 class="fw-bold mb-3">
            <i class="bi bi-question-circle-fill text-primary me-2"></i>
            Pertanyaan yang Sering Diajukan
        </h6>

        <div class="accordion accordion-flush" id="faqAccordion">

            {{-- FAQ 1 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq1">

                        Bagaimana cara membuat laporan?

                    </button>

                </h2>

                <div
                    id="faq1"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Login terlebih dahulu, kemudian pilih menu
                        <b>Buat Laporan Baru</b>, unggah foto kerusakan,
                        tentukan lokasi pada peta, lengkapi deskripsi,
                        lalu tekan tombol <b>Kirim</b>.

                    </div>

                </div>

            </div>

            {{-- FAQ 2 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq2">

                        Siapa yang memverifikasi laporan?

                    </button>

                </h2>

                <div
                    id="faq2"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Seluruh laporan akan diverifikasi oleh administrator
                        sebelum diproses atau diteruskan kepada instansi terkait.

                    </div>

                </div>

            </div>

            {{-- FAQ 3 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq3">

                        Mengapa laporan saya ditolak?

                    </button>

                </h2>

                <div
                    id="faq3"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Laporan dapat ditolak apabila informasi tidak lengkap,
                        lokasi tidak sesuai, foto tidak jelas,
                        atau merupakan laporan yang sama dengan laporan sebelumnya.

                    </div>

                </div>

            </div>

            {{-- FAQ 4 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq4">

                        Bagaimana cara mengetahui perkembangan laporan?

                    </button>

                </h2>

                <div
                    id="faq4"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Status laporan dapat dipantau melalui menu
                        <b>Laporan Saya</b> yang berada di halaman <b>Profil</b>.
                        Status laporan meliputi
                        <b>Terkirim</b>,
                        <b>Diproses</b>,
                        <b>Diteruskan</b>,
                        <b>Selesai</b>,
                        atau
                        <b>Ditolak</b>.

                    </div>

                </div>

            </div>

            {{-- FAQ 5 --}}
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq5">

                        Apakah lokasi saya harus berada di Kabupaten Wonogiri?

                    </button>

                </h2>

                <div
                    id="faq5"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                    Tidak. Anda dapat mengakses aplikasi dan mengirim laporan dari mana saja. Namun, lokasi kerusakan jalan yang dilaporkan harus berada di wilayah Kabupaten Wonogiri.

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

   

  

</div>
{{-- Download --}}
    <div class="download-card">

    <div class="download-icon">

        <i class="bi bi-phone-fill"></i>

    </div>

    <div class="flex-grow-1">

        <div class="download-title">

            Download aplikasi

        </div>

        <div class="download-desc">

            untuk akses lebih cepat!

        
</div>
    </div>

   <button type="button" class="btn-download" id="installPwaBtn">
    <i class="bi bi-download"></i>
    Install Aplikasi
</button>
    
</div>
<div class="modal fade" id="installHelpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-phone"></i>
                    Cara Install Aplikasi
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>

            <div class="modal-body">

                <div id="installInstructions"></div>

            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-primary"
                        data-bs-dismiss="modal">
                    Mengerti
                </button>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')

<script>
document.addEventListener("DOMContentLoaded", function(){

    document.querySelectorAll(".counter").forEach(counter=>{

        const target = parseInt(counter.dataset.target);

        let start = 0;
        const duration = 1200;
        const startTime = performance.now();

        function animate(now){

            const progress = Math.min((now-startTime)/duration,1);

            // efek melambat di akhir
            const ease = 1-Math.pow(1-progress,3);

            counter.textContent = Math.floor(ease*target);

            if(progress<1){
                requestAnimationFrame(animate);
            }else{
                counter.textContent = target;
            }

        }

        requestAnimationFrame(animate);

    });

});


let deferredPrompt = null;


// ========================================
// DETEKSI SEBELUM INSTALL
// ========================================

window.addEventListener('beforeinstallprompt', function(event) {

    event.preventDefault();

    deferredPrompt = event;

    console.log('PWA siap di-install.');

});


// ========================================
// TOMBOL INSTALL
// ========================================

document.addEventListener('DOMContentLoaded', function() {

    const installBtn = document.getElementById('installPwaBtn');

    if (!installBtn) return;


    installBtn.addEventListener('click', async function() {


        // ====================================
        // BROWSER MENDUKUNG INSTALL PROMPT
        // ====================================

        if (deferredPrompt) {

            deferredPrompt.prompt();

            const { outcome } = await deferredPrompt.userChoice;

            console.log('Hasil instalasi:', outcome);

            deferredPrompt = null;

            return;
        }


        // ====================================
        // BROWSER TIDAK MENDUKUNG PROMPT
        // ====================================

        showInstallInstructions();

    });

});


// ========================================
// PETUNJUK INSTALL MANUAL
// ========================================

function showInstallInstructions() {

    const instructions =
        document.getElementById('installInstructions');

    if (!instructions) return;


    const userAgent = navigator.userAgent.toLowerCase();

    let html = '';


    // ====================================
    // IPHONE / IPAD
    // ====================================

    if (
        /iphone|ipad|ipod/.test(userAgent)
    ) {

        html = `
            <div class="text-center mb-3">
                <i class="bi bi-phone"
                   style="font-size: 45px;">
                </i>
            </div>

            <p>
                Untuk menginstall aplikasi di iPhone atau iPad:
            </p>

            <ol>
                <li>
                    Buka website menggunakan
                    <strong>Safari</strong>.
                </li>

                <li>
                    Tekan tombol
                    <strong>Bagikan (Share)</strong>.
                </li>

                <li>
                    Pilih
                    <strong>Tambahkan ke Layar Utama</strong>.
                </li>

                <li>
                    Tekan <strong>Tambah</strong>.
                </li>
            </ol>

            <div class="alert alert-info">
                Setelah itu, ikon
                <strong>Lapor Jalan</strong>
                akan muncul di layar utama.
            </div>
        `;

    }


    // ====================================
    // ANDROID
    // ====================================

    else if (/android/.test(userAgent)) {

        html = `
            <div class="text-center mb-3">
                <i class="bi bi-phone"
                   style="font-size: 45px;">
                </i>
            </div>

            <p>
                Jika tombol install otomatis tidak muncul:
            </p>

            <ol>
                <li>
                    Tekan menu
                    <strong>⋮</strong>
                    pada browser.
                </li>

                <li>
                    Pilih
                    <strong>Install aplikasi</strong>
                    atau
                    <strong>Tambahkan ke layar utama</strong>.
                </li>

                <li>
                    Konfirmasi dengan menekan
                    <strong>Install</strong>
                    atau <strong>Tambah</strong>.
                </li>
            </ol>
        `;

    }


    // ====================================
    // DESKTOP
    // ====================================

    else {

        html = `
            <div class="text-center mb-3">
                <i class="bi bi-laptop"
                   style="font-size: 45px;">
                </i>
            </div>

            <p>
                Browser kamu tidak menyediakan tombol
                instalasi otomatis dari aplikasi.
            </p>

            <p>
                Coba buka menu browser
                <strong>⋮</strong>,
                kemudian cari:
            </p>

            <ul>
                <li>
                    <strong>Install Lapor Jalan</strong>
                </li>

                <li>
                    <strong>Install app</strong>
                </li>

                <li>
                    <strong>Instal aplikasi</strong>
                </li>
            </ul>
        `;

    }


    instructions.innerHTML = html;


    // ====================================
    // TAMPILKAN MODAL
    // ====================================

    const modalElement =
        document.getElementById('installHelpModal');

    if (modalElement) {

        const modal =
            new bootstrap.Modal(modalElement);

        modal.show();

    }

}


// ========================================
// SETELAH BERHASIL INSTALL
// ========================================

window.addEventListener('appinstalled', function() {

    console.log(
        'Lapor Jalan berhasil di-install.'
    );

    deferredPrompt = null;

});


</script>

@endsection