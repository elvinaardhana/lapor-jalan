<!DOCTYPE html>
<html lang="id">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="icon"
      type="image/png"
      href="{{ asset('images/logo.png') }}">
    <style>
html,
body{
    height:100%;
    margin:0;
    overflow:hidden;
    background:#f4f6fb;
    font-family:"Poppins",sans-serif;
}

.admin-layout{
    display:grid;
    grid-template-columns:240px 1fr;
    height:100vh;
}
.logout-form{
    margin:6px 12px 12px;
}

.logout-btn{
    width:100%;
    display:flex;
    align-items:center;
    gap:12px;
    color:#fff;
    background:transparent;
    border:none;
    padding:14px 24px;
    border-radius:12px;
    transition:.2s;
}

.logout-btn:hover{
    background:rgba(255,255,255,.15);
}
.sidebar{

height:100vh;

overflow-y:auto;

background:linear-gradient(
    180deg,
    #5F7FA8 0%,
    #4E688C 45%,
    #354A67 100%
);

border-right:1px solid rgba(255,255,255,.15);

}

.sidebar h4{
    padding:24px;
    font-size:1.8rem;
    font-weight:700;
}

.sidebar a{

    display:flex;
    align-items:center;
    gap:12px;

    color:#fff;
    text-decoration:none;

    padding:14px 24px;

    margin:6px 12px;

    border-radius:12px;

    transition:.2s;
}

.sidebar a i{
    font-size:18px;
}

.sidebar a:hover{

    background:rgba(255,255,255,.15);

}

.sidebar a.active{

    background:#fff;

    color:#1f6feb;

    font-weight:600;

}

.content{

height:100vh;

overflow-y:auto;

padding:30px;

background:#f4f6fb;

}
.dashboard-card{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:22px 26px;

    border-radius:18px;

    color:white;

    box-shadow:0 8px 20px rgba(0,0,0,.10);

    transition:.25s;

}

.dashboard-card:hover{

    transform:translateY(-4px);

}

.dashboard-card h2{

    font-size:2rem;

    font-weight:700;

    margin-bottom:4px;

}

.dashboard-card p{

    margin:0;

    font-size:1rem;

    opacity:.95;

}
.card-icon{

width:60px;
height:60px;
border-radius:16px;

background:rgba(255,255,255,.18);

display:flex;
align-items:center;
justify-content:center;

color:#fff;
}

.card-icon i{

    font-size:28px;

}

/* Gradient */

.bg-user{
    background:linear-gradient(135deg,#4f8ef7,#2563eb);
}

.bg-report{
    background:linear-gradient(135deg,#7c3aed,#5b21b6);
}

/* Terkirim - Abu */
.bg-terkirim{
    background:linear-gradient(135deg,#9CA3AF,#6B7280);
}

/* Diproses - Kuning */
.bg-diproses{
    background:linear-gradient(135deg,#FACC15,#EAB308);
}

/* Diteruskan - Biru */
.bg-diteruskan{
    background:linear-gradient(135deg,#3B82F6,#2563EB);
}

/* Selesai - Hijau */
.bg-selesai{
    background:linear-gradient(135deg,#22C55E,#16A34A);
}


.content h2{

font-size:2.2rem;

font-weight:700;

}

.content p{

font-size:1rem;

}
.sidebar-header{
    text-align:center;
    padding:28px 20px 20px;
}

.sidebar-logo{
    width:80px;
    height:80px;
    object-fit:contain;
    margin-bottom:14px;
}

.sidebar-title{
    color:#fff;
    font-size:1.1rem;
    font-weight:700;
    line-height:1.3;
    margin-bottom:6px;
}

.sidebar-subtitle{
    color:rgba(255,255,255,.75);
    font-size:.8rem;
    margin-bottom:10px;
}

.sidebar-divider{
    border-top:1px solid rgba(255,255,255,.2);
    margin:0 18px 14px;
}

/* analisis prioritas */
.leaflet-popup-content{
    margin:12px;
}

.leaflet-popup-content table{
    margin-bottom:0;
}

.card{
    border-radius:15px;
}

#map{

height:calc(100vh - 270px);

min-height:520px;

border-radius:16px;
margin-top:12px;
}

.popup-card{
    width:260px;
    font-size:13px;
}

.popup-header{
    margin-bottom:6px;
}

.popup-card h5{
    font-size:15px;
    margin-bottom:2px;
}

.popup-desc{
    font-size:12px;
    margin:6px 0;
    line-height:1.35;
}

.popup-card table td{
    padding:4px 2px;
}

.popup-card table{
    margin-bottom:8px;
}

.score-box{
    padding-top:8px;
    margin-top:6px;
}

.score-box h3{
    font-size:20px;
}

.leaflet-popup-content{
    margin:10px;
}
.btn-detail{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;

    margin-top:12px;
    padding:7px 14px;

    border:2px solid #2563eb;
    border-radius:8px;

    background:#fff;
    color:#2563eb;
    text-decoration:none;

    font-size:13px;
    font-weight:600;

    transition:.2s;
}

.btn-detail:hover{
    background:#2563eb;
    color:#fff;
}
.btn-detail i{
    font-size:14px;
}
.popup-card .badge{
    font-size:9px !important;
    font-weight:600;
    padding:2px 6px;
    border-radius:10px;
    line-height:1.3;
}

/* tabel laporan */
.filter-label{
    font-size:12px;
    color:#6c757d;
    margin-bottom:5px;
}

.form-select,
.form-control,
.input-group-text{
    min-height:40px;
}

.input-group-text{
    border-radius:8px 0 0 8px;
}

.form-control{
    border-radius:8px;
}
.periode-info{
    font-size:13px;
    color:#6c757d;
}

.total-box{
    min-width:95px;
    padding:7px 14px;
    border-radius:12px;
    background:#f5f8ff;
}

.total-box small{
    font-size:12px;
    color:#6c757d;
}

.total-number{
    font-size:24px;
    font-weight:700;
    line-height:1.1;
    color:#0d6efd;
}

.filter-periode{
    width:180px;
}

.filter-tahun{
    width:130px;
}

.filter-periode .form-label,
.filter-tahun .form-label{
    font-size:12px;
    color:#6c757d;
    margin-bottom:5px;
}

.filter-action{
    height:38px;
    min-width:145px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    white-space:nowrap;
}

.card-body .form-control,
.card-body .form-select{
    height:38px;
}
.card-body .form-control,
.card-body .form-select{
    min-height:38px;
}

.table th{
    white-space:nowrap;
}

.table td,
.table th{
    vertical-align:middle;
}
.pagination{

margin-bottom:0;

}

.pagination .page-link{

border:none;

color:#355070;

border-radius:10px;

margin:0 3px;

padding:8px 14px;

}

.pagination .page-item.active .page-link{

background:#4E8FDF;

color:#fff;

}

.pagination .page-link:hover{

background:#EEF4FF;

}
.table thead th{
    background:#EEF4FF;
    color:#355070;
    border:none;
    font-weight:700;
    padding:15px;
}
.table tbody td{
    vertical-align:middle;
    padding:14px 15px;
    border-color:#edf2f7;
}

.table tbody tr{
    transition:.2s;
}

.table tbody tr:hover{
    background:#f8fbff;
}
.badge-status{
    display:inline-flex;
    align-items:center;
    justify-content:center;

    min-width:95px;

    padding:8px 16px;

    border-radius:999px;

    font-size:.8rem;

    font-weight:600;
}
/* Terkirim */
.badge-terkirim{
    background:#F3F4F6;
    color:#4B5563;
}

/* Diproses */
.badge-proses{
    background:#FEF3C7;
    color:#B45309;
}

/* Diteruskan */
.badge-diteruskan{
    background:#DBEAFE;
    color:#1D4ED8;
}

/* Selesai */
.badge-selesai{
    background:#DCFCE7;
    color:#15803D;
}

/* Ditolak */
.badge-ditolak{
    background:#FEE2E2;
    color:#DC2626;
}
.btn-detail{
    border:1.5px solid #4E8FDF;
    color:#4E8FDF;
    background:#fff;
    border-radius:25px;
    padding:6px 14px;
    text-decoration:none;
    transition:.2s;
}

.btn-detail:hover{
    background:#4E8FDF;
    color:#fff;
}
.table{
    width:100%;
    margin-bottom:0;
}

.table>:not(caption)>*>*{
    border-bottom:1px solid #edf2f7;
}

.table tbody tr{
    border-left:4px solid transparent;
}

.table tbody tr:hover{
    border-left:4px solid #4E8FDF;
    background:#f8fbff;
}

.hapus-icon{
    width:64px;
    height:64px;
    border-radius:50%;
    background:#fff1f2;
    color:#dc3545;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:28px;
}

.modal-content{
    animation:modalMasuk .2s ease;
}

@keyframes modalMasuk{

    from{
        opacity:0;
        transform:translateY(10px) scale(.97);
    }

    to{
        opacity:1;
        transform:translateY(0) scale(1);
    }

}


/* ===========================
   DETAIL LAPORAN
===========================*/
.keterangan-textarea{
    height:auto !important;
    min-height:110px;
    resize:vertical;
    line-height:1.5;
    padding:12px 14px;
}

.update-card small.text-muted{
    display:block;
    margin-top:6px;
    line-height:1.4;
}
.laporan-photo {
    width: 100%;
    max-height: 420px;
    object-fit: contain;
    cursor: zoom-in;
    border-radius: 16px;
    background: #f5f5f5;
}

.foto-full {
    max-width: 100%;
    max-height: 90vh;
    width: auto;
    height: auto;
    object-fit: contain;
    border-radius: 12px;
    cursor: zoom-out;
}
.page-title{
    font-size:28px;
    font-weight:700;
    color:#23456b;
}

.subtitle{
    color:#6c757d;
    font-size:.95rem;
}

.section-card{
    border:none;
    border-radius:20px;
    box-shadow:0 8px 24px rgba(0,0,0,.06);
    overflow:hidden;
    transition:.25s;
}

.section-card:hover{
    transform:translateY(-2px);
    box-shadow:0 14px 32px rgba(0,0,0,.08);
}

.section-title{
    font-size:20px;
    font-weight:700;
    color:#23456b;
}

.photo-card img{
    width:100%;
    height:430px;
    object-fit:cover;
}

.info-card{
    background:#f8fafc;
    border:1px solid #e9ecef;
    border-radius:16px;
    padding:18px;
    height:100%;
}

.info-card small{
    display:block;
    color:#6c757d;
    margin-bottom:6px;
}

.info-card h6{
    margin:0;
    font-weight:600;
}

.badge-status{
    font-size:.9rem;
    padding:10px 18px;
    border-radius:999px;
}

.form-select{
    border-radius:12px;
    min-height:50px;
}

.form-select:focus{
    border-color:#4e73df;
    box-shadow:0 0 0 .2rem rgba(78,115,223,.15);
}

.btn-primary{
    border-radius:12px;
}



.update-card{
    position:sticky;
    top:20px;
}

.analysis-box{
    border:1px solid #e9ecef;
    border-radius:16px;
    padding:20px;
    background:#fff;
    height:100%;
}

.analysis-title{
    color:#6c757d;
    font-size:.9rem;
    margin-bottom:8px;
}

.analysis-value{
    font-weight:600;
    font-size:1.05rem;
}

.analysis-score{
    font-size:52px;
    font-weight:700;
    color:#2563eb;
    line-height:1;
}

.facility-item{
    display:flex;
    align-items:flex-start;
    gap:10px;
    margin-bottom:10px;
}

.facility-item i{
    color:#dc3545;
    margin-top:3px;
}

@media (max-width:991px){

    .update-card{
        position:static;
    }

    .photo-card img{
        height:280px;
    }

    .analysis-score{
        font-size:40px;
    }

}

/* scroll bar */
.content::-webkit-scrollbar{
    width:8px;
}

.content::-webkit-scrollbar-track{
    background:transparent;
}

.content::-webkit-scrollbar-thumb{
    background:#cbd5e1;
    border-radius:10px;
}

.content::-webkit-scrollbar-thumb:hover{
    background:#94a3b8;
}

/* peta prioritas */
.leaflet-popup-content{
    max-height:320px;
    overflow-y:auto;
    padding-right:6px;
}
.stat-card{
    border:none;
    border-radius:18px;
    overflow:hidden;
    transition:.25s;
    background:#fff;
}

.stat-card:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 30px rgba(0,0,0,.12);
}

.stat-icon{
    width:56px;
    height:56px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    margin-bottom:10px;
}
.filter-box{
    display:flex;
    gap:20px;
    align-items:end;

    background:#f8fafc;
    border-radius:14px;

    padding:8px;
}

.filter-item{
    transition:all .25s ease;
    border-radius:12px;
}

.form-select{
    transition:all .25s ease;
    border:1px solid #d6dbe4;
    border-radius:12px;
}

.form-select:hover{
    border-color:#4E8FDF;
    box-shadow:0 6px 16px rgba(78,143,223,.15);
    cursor:pointer;
}

.form-select:focus{
    border-color:#4E8FDF;
    box-shadow:0 0 0 .2rem rgba(78,143,223,.2);
}
.filter-item label{
    display:block;
    margin-bottom:6px;
    font-size:.9rem;
    font-weight:600;
    color:#64748b;
}

#filterPeriode{
    width:190px;
    height:46px;
    border-radius:12px;
}

#filterPrioritas{
    width:190px;
    height:46px;
    border-radius:12px;
}
@media(max-width:768px){

.filter-box{

flex-direction:column;

}

.filter-box .form-select{

width:100%;

}

}

.map-title-wrapper{
    flex: 1;
    min-width: 0;
}

.map-title-wrapper h3{
    white-space: normal;
    overflow-wrap: normal;
}

.filter-box{
    flex-shrink: 0;
}

.priority-icon{
    width:40px;
    height:40px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto;
    color:white;
    font-size:20px;
}

.priority-high{
    background:#dc3545;
}

.priority-medium{
    background:#ffc107;
}

.priority-low{
    background:#198754;
}
.legend-priority{
    width:20px;
    height:20px;
    border-radius:50%;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    margin-right:8px;
    color:white;
    font-size:11px;
    flex-shrink:0;
}

.legend-high{
    background:#dc3545;
}

.legend-medium{
    background:#ffc107;
}

.legend-low{
    background:#198754;
}

    </style>

</head>
<body>

<div class="admin-layout">

    <aside class="sidebar">

        <div class="sidebar-header">

        <img src="{{ asset('images/Logo putih.png') }}"
     class="sidebar-logo"
     alt="Logo">

            <div class="sidebar-title">
                Lapor Kerusakan Jalan
            </div>

            <div class="sidebar-subtitle">
                Kabupaten Wonogiri
            </div>

        </div>

        <div class="sidebar-divider"></div>

        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active':'' }}">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.laporan') }}"
           class="{{ request()->routeIs('admin.laporan') ? 'active':'' }}">
            <i class="bi bi-file-earmark-text"></i>
            Laporan
        </a>

        <a href="{{ route('admin.petaPrioritas') }}"
           class="{{ request()->routeIs('admin.petaPrioritas') ? 'active':'' }}">
            <i class="bi bi-map"></i>
            Peta Prioritas
        </a>

        <a href="{{ route('akun') }}"
           class="{{ request()->routeIs('akun') ? 'active':'' }}">
            <i class="bi bi-phone"></i>
            Tampilan User
        </a>

        <form action="{{ route('logout') }}"
              method="POST"
              class="logout-form">

            @csrf

            <button class="logout-btn">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </button>

        </form>

    </aside>

    <main class="content">

        @yield('content')

    </main>

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</body>
</html>