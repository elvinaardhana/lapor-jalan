<!DOCTYPE html>
<html lang="id">

<head>
<link rel="icon"
      type="image/png"
      href="{{ asset('images/logo.png') }}">
    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1">

        <!-- manifest PWA -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">

<meta name="theme-color" content="#4E8FDF">

<link rel="apple-touch-icon"
      href="{{ asset('icons/icon-192.png') }}">
    <title>@yield('title')</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icon -->

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Font Awesome -->

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<!-- leaflet -->
        <link rel="stylesheet"
        href="https://unpkg.com/leaflet/dist/leaflet.css"/>
   
   <!-- peta -->
   <link rel="stylesheet"
href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">

<link rel="stylesheet"
href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">
   
   <style>
       
       .bottom-nav{
    position:fixed;
    left:50%;
    bottom:10px;
    transform:translateX(-50%);

    width:95%;
    max-width:400px;

    background:#fff;
    border-radius:28px;

    display:flex;
    justify-content:space-around;
    align-items:center;

    padding:6px 6px;
    box-shadow:0 8px 25px rgba(0,0,0,.12);

    z-index:1000;
}
.badge-status {
    flex-shrink: 0;
    align-self: flex-start;
    white-space: nowrap;
}
.nav-item{

    display:flex;
    flex-direction:column;
    align-items:center;

    text-decoration:none;

    color:#6b7280;

    font-size:11px;

    transition:.25s;

    flex:1;

}

.nav-icon{

    width:42px;
    height:42px;

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    transition:.25s;

}

.nav-icon i{

    font-size:20px;

}

.nav-item.active{

    color:#0d6efd;

}

.nav-item.active .nav-icon{

width:42px;
height:42px;

background:#e9f2ff;

border-radius:50%;

box-shadow:0 0 12px rgba(13,110,253,.18);

}

.nav-item span{

    margin-top:3px;

}

.center-icon{

    width:46px;
    height:46px;

    background:#0d6efd;

    color:white;

    box-shadow:0 0 0 5px rgba(13,110,253,.08);
}

.center-icon i{

    font-size:24px;

}

.center.active .center-icon{

    background:#0b5ed7;

}
        body{

            background:#eceff3;

        }

        .mobile{

            max-width:430px;

            margin:auto;

            background:white;

            min-height:100vh;

            position:relative;

            overflow:hidden;

            box-shadow:0 0 20px rgba(0,0,0,.08);

        }
        .content{
    padding:15px;
    padding-bottom:90px;
    min-height:calc(100vh - 70px);
}
/* foto input laporan */
.border-dashed{
    border-style:dashed !important;
    border-color:#b8c2cc !important;
    transition:.3s;
}

.border-dashed:hover{
    border-color:#0d6efd !important;
    background:#f8fbff;
}

/* pop up laporan */

.swal-mobile{
    width:90% !important;
    max-width:320px !important;
    border-radius:18px !important;
}
.swal2-title{
    font-size: 1.6rem !important;
}

.swal2-html-container{
    font-size: .95rem !important;
}

.swal2-icon{
    transform: scale(.85);
    margin-top: .5rem !important;
} 

/* akun */
.profile-avatar-empty{

width:110px;
height:110px;

margin:auto;

border-radius:50%;

background:#ECEFF3;

color:#4E688C;

display:flex;
justify-content:center;
align-items:center;

font-size:55px;

}
.profile-avatar{

width:100px;
height:100px;

border-radius:50%;

margin:auto;

background:linear-gradient(135deg,#4E688C,#6882A6);

display:flex;

justify-content:center;

align-items:center;

color:#fff;

font-size:36px;

font-weight:bold;

box-shadow:0 10px 25px rgba(78,104,140,.25);

}
.profile-card{

display:block;

background:#fff;

border-radius:18px;

padding:18px;

margin-bottom:18px;

box-shadow:0 8px 18px rgba(0,0,0,.08);

transition:.2s;

}

.profile-card:hover{

transform:translateY(-2px);

}

.card-icon{

width:48px;

height:48px;

border-radius:14px;

background:#EEF4FF;

display:flex;

justify-content:center;

align-items:center;

color:#0d6efd;

font-size:22px;

}
.btn-login-akun{

width:170px;

border-radius:25px;

background:#4E688C;

color:white;

font-weight:600;

}

.btn-login-akun:hover{

background:#425979;

color:white;

}
.btn-logout{
    width: 140px;
    height: 46px;
    margin: 30px auto;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:8px;

    border:2px solid #4E8FDF;
    border-radius:30px;

    background:#fff;
    color:#4E8FDF;

    font-weight:600;
    transition:.25s;
}

.btn-logout:hover{
    background:#6BA7F2;
    color:#fff;
    box-shadow:0 8px 18px rgba(78,143,223,.25);
    transform:translateY(-2px);
}
/* dashboard user */
.status-info-item{
    display:flex;
    align-items:flex-start;
    gap:12px;
}

.status-dot{
    width:34px;
    height:34px;
    min-width:34px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:14px;
}

.status-terkirim{
    background:#6c757d;
}

.status-diproses{
    background:#f59e0b;
}

.status-diteruskan{
    background:#0d6efd;
}

.status-selesai{
    background:#198754;
}

.status-ditolak{
    background:#dc3545;
}

.status-divider{
    height:1px;
    background:#edf0f3;
    margin:12px 0;
}

.status-chevron{
    color:#6c757d;
    transition:transform .25s ease;
}

button[aria-expanded="true"] .status-chevron{
    transform:rotate(180deg);
}
.periode-bulan{
    font-size: .9rem;
    font-weight: 600;
    color: #4E688C;
}
.hero-card{
    background:linear-gradient(
        180deg,
        #5C789E 0%,
        #4E688C 45%,
        #3F5675 100%
    );
    padding:18px;
    border-radius:20px;
    margin-bottom:18px;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
}
.hero-logo{
    width:80px;
}

.hero-card h4{
    font-size:1.4rem;
    line-height:1.25;
    margin-bottom:6px;
}

.hero-card p{
    font-size:.8rem;
    margin-bottom:0;
}
.stat-card{
    padding:18px;
    border-radius:18px;
    margin-bottom:18px;
}

.stat-card h6{
    font-size:16px;
    margin-bottom:14px;
}

.stat-box{
    padding:8px 6px;
    border-radius:14px;
}

.stat-box small{
    font-size:11px;
}

.stat-box h3{
    font-size:30px;
    margin-top:2px;
    margin-bottom:0;
}
.stat-box.red{
    background:#fff5f5;
    border:2px solid #ff6b6b;
    color:#e03131;
}

.stat-box.orange{
    background:#fff8e6;
    border:2px solid #ff922b;
    color:#e67700;
}

.stat-box.green{
    background:#ebfbee;
    border:2px solid #51cf66;
    color:#2b8a3e;
}

.btn-lapor{

display:flex;
align-items:center;

background:#4E8FDF;

border-radius:18px;

padding:16px 20px;

color:#fff;
text-decoration:none;

box-shadow:0 5px 14px rgba(0,0,0,.15);
margin-bottom:18px;
height:60px;
}

.btn-icon{

width:40px;
height:40px;

background:#fff;

border-radius:50%;

display:flex;
align-items:center;
justify-content:center;

margin-right:16px;

}

.btn-icon i{

color:#4E8FDF;

font-size:28px;

}

.btn-title{

font-size:15px;

font-weight:600;

}

.btn-subtitle{

font-size:11px;

opacity:.95;

}

.btn-lapor:hover{
    color:white;
    background:#3d7ed0;
}

.menu-card{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#f5f5f5;
    border-radius:16px;
    padding:18px;
    text-decoration:none;
    color:#444;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.tips-card{

display:flex;

align-items:center;

gap:14px;

background:#eaf3ff;

border:1px solid #bfdcff;

border-radius:18px;

padding:14px 18px;

box-shadow:0 4px 12px rgba(0,0,0,.12);
margin-bottom:15px;
}

.tips-icon{

width:42px;
height:42px;

background:#d8e8ff;

border-radius:50%;

display:flex;
align-items:center;
justify-content:center;

}

.tips-icon i{

color:#ffd500;

font-size:24px;

}

.tips-title{

font-weight:700;

color:#24508d;

font-size:15px;

}

.tips-desc{

font-size:10px;

line-height:1.35;

}

.download-card{

display:flex;

align-items:center;

gap:14px;

background:#fff;

border-radius:18px;

padding:16px 18px;

box-shadow:0 4px 12px rgba(0,0,0,.12);
margin-bottom:15px;
}

.download-icon{

width:42px;

height:42px;

background:#dcecff;

border-radius:50%;

display:flex;

align-items:center;

justify-content:center;

}

.download-icon i{

font-size:24px;

}

.download-title{

font-size:13px;

font-weight:700;

color:#24508d;

}

.download-desc{

font-size:12px;

color:#666;

}

.btn-download{

background:#4E8FDF;

color:#fff;

padding:8px 14px;

border-radius:8px;

text-decoration:none;

font-size:12px;

font-weight:600;

}

/* statistik laporan dashboard */
.stat-box{
    animation:fadeUp .6s ease;
    transition:.25s;
}

.stat-box:nth-child(1){
    animation-delay:.1s;
}

@keyframes fadeUp{

    from{
        opacity:0;
        transform:translateY(20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}
.stat-box:hover{

transform:translateY(-4px);

box-shadow:0 10px 25px rgba(0,0,0,.12);

}

.hero-card{

    animation:slideDown .7s ease;

}

@keyframes slideDown{

    from{

        opacity:0;

        transform:translateY(-20px);

    }

    to{

        opacity:1;

        transform:translateY(0);

    }

}

/* FAQ */
.accordion-item{
    border:none;
    border-bottom:1px solid #ececec;
}

.accordion-button{
    font-weight:600;
    font-size:15px;
    background:#fff;
    box-shadow:none !important;
    padding:16px 0;
}

.accordion-button:not(.collapsed){
    background:#fff;
    color:#4E8FDF;
}

.accordion-button::after{
    transition:.3s;
}

.accordion-body{
    color:#666;
    font-size:14px;
    line-height:1.7;
    padding:0 0 18px 0;
}
.admin-card{
    display:block;
    margin-top:12px;
    padding:12px 16px;
    border-radius:14px;
    background: linear-gradient(
    to bottom right,
    #72ACEF,
    #4E8FDF,
    #3F7FCE
);
    box-shadow:0 5px 12px rgba(37,99,235,.18);
    transition:.25s;
}

.admin-card:hover{
    transform:translateY(-2px);
}

.admin-icon{
    width:40px;
    height:40px;
    border-radius:10px;
    background:rgba(255,255,255,.2);
    display:flex;
    align-items:center;
    justify-content:center;
}

.admin-icon i{
    color:#fff;
    font-size:18px;
}

.admin-card .fw-bold{
    font-size:15px;
    margin-bottom:2px;
}

.admin-card small{
    font-size:12px;
}

.admin-card .bi-arrow-right-circle-fill{
    font-size:20px !important;
}

/* filter peta */
.filter-wrapper{

display:flex;

align-items:center;

gap:10px;

background:#f8fbff;

border-radius:10px;
border:1px solid #dbe5f2;
padding:6px;

box-shadow:
    inset 0 1px 2px rgba(255,255,255,.8),
    0 5px 18px rgba(0,0,0,.06);

}

.filter-select{

flex:1;

border:none !important;

background:transparent !important;

font-weight:600;

color:#355b8c;

font-size:14px;

padding:0 12px;

height:40px;

box-shadow:none !important;


}

.filter-select:focus{

outline:none;

box-shadow:none !important;

}

.filter-divider{

width:1px;

height:28px;

background:#dbe5f2;

}

.btn-filter{

width:40px;

height:40px;

border:none;

border-radius:14px;

background:#4E8FDF;

color:white;

display:flex;

align-items:center;

justify-content:center;

transition:.25s;

box-shadow:0 5px 15px rgba(78,143,223,.35);

}

.btn-filter:hover{

background:#3c7ed4;

transform:translateY(-2px);

}

.btn-filter i{

font-size:18px;

}

/* ===========================
   Responsive Hero & Statistik
=========================== */

@media (max-width:430px){

/* ===== HERO ===== */
.hero-card{
    padding:20px 18px;
}

.hero-card .d-flex{
    min-height:95px;
}

.hero-logo{
    width:78px;
    height:78px;
}
.hero-card .ms-3{
    margin-left:0 !important;
    flex:1;
    min-width:0;
}

.hero-card h4{
    font-size:1.05rem;
    line-height:1.25;
    margin-bottom:6px;
}

.hero-card p{
    font-size:.72rem;
    line-height:1.45;
    margin-bottom:0;
}

/* ===== STATISTIK ===== */

.card-body{
    padding:16px;
}

.card-body>.d-flex{
    margin-bottom:14px !important;
}

.card-body h6{
    font-size:1rem;
}

.periode-bulan{
    font-size:.75rem;
    white-space:nowrap;
}

.row.text-center{
    --bs-gutter-x:.6rem;
}

.stat-box{
    padding:10px 4px;
    min-height:86px;
    border-radius:14px;
}

.stat-box small{
    display:block;
    font-size:9px;
    line-height:1.3;
}

.stat-box h3{
    font-size:30px;
    margin-top:6px;
    margin-bottom:0;
}

}
.info-toggle{
    background:#f8fbff;
    border:1px solid #cfe2ff;
    color:#0d6efd;
    border-radius:8px;
    padding:11px 14px;
    font-size:15px;
    font-weight:500;
    transition:.2s ease;
}

.info-toggle:hover{
    background:#eef5ff;
    border-color:#9ec5fe;
}

.info-toggle:focus{
    outline:none;
    box-shadow:0 0 0 3px rgba(13,110,253,.12);
}

.info-content{
    background:#fff;
    border:1px solid #dbe7f5;
    border-radius:10px;
    padding:14px;
    box-shadow:0 2px 8px rgba(0,0,0,.04);
}

.info-item{
    display:flex;
    gap:12px;
    align-items:flex-start;
}

.info-icon{
    width:34px;
    height:34px;
    min-width:34px;
    border-radius:50%;
    background:#e7f1ff;
    color:#0d6efd;
    display:flex;
    align-items:center;
    justify-content:center;
}

.info-divider{
    height:1px;
    background:#edf1f5;
    margin:13px 0;
}

.info-chevron{
    transition:transform .25s ease;
}

.info-toggle[aria-expanded="true"] .info-chevron{
    transform:rotate(180deg);
}
    </style>

</head>

<body>

<div class="mobile">
@hasSection('header')
    @yield('header')
@endif

    <div class="content">

        @yield('content')

    </div>

    @include('components.bottom-nav')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<script src="https://unpkg.com/leaflet.featuregroup.subgroup/dist/leaflet.featuregroup.subgroup.js"></script>
<!-- pop up -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))


<script>
Swal.fire({
    icon: 'success',
    title: 'Laporan Berhasil',
    text: '{{ session("success") }}',
    confirmButtonColor: '#198754',
    confirmButtonText: 'OK',
    
    customClass:{
        popup:'swal-mobile'
    }
});
</script>
@endif
<!-- pop up -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('login_success'))


<script>
Swal.fire({
    icon: 'success',
    title: 'Selamat Datang!',
    text: 'Anda berhasil masuk ke aplikasi.',
    confirmButtonText: 'Lanjut',
    confirmButtonColor: '#198754',

    customClass:{
        popup:'swal-mobile'
    }
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Laporan Gagal',
    text: '{{ session("error") }}',
    confirmButtonColor: '#dc3545',
    confirmButtonText: 'OK',

    customClass:{
        popup:'swal-mobile'
    }
});
</script>
@endif

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Data Belum Lengkap',
        html: '{{ $errors->first() }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#dc3545',
        customClass:{
        popup:'swal-mobile'
    }
    });
});
</script>
@endif


@yield('scripts')

<!-- service worker PWA -->
<script>

if ('serviceWorker' in navigator) {

    window.addEventListener('load', function () {

        navigator.serviceWorker
            .register('{{ asset('sw.js') }}')
            .then(function (registration) {

                console.log(
                    'Service Worker berhasil:',
                    registration.scope
                );

            })
            .catch(function (error) {

                console.error(
                    'Service Worker gagal:',
                    error
                );

            });

    });

}

</script>
</body>

</html>