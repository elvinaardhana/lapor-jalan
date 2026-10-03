<!DOCTYPE html>
<html lang="id">
<head>
    
    <link rel="icon"
      type="image/png"
      href="{{ asset('images/logo.png') }}">
    <!-- leaflet -->
<link rel="stylesheet"
      href="https://unpkg.com/leaflet/dist/leaflet.css" />

      <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<style>

body{

    background:#eceff3;

}

.mobile{

    max-width:430px;

    margin:auto;

    background:#fff;

    min-height:100vh;

    box-shadow:0 0 20px rgba(0,0,0,.08);

}
.back-link{

width:38px;
height:38px;

display:flex;
align-items:center;
justify-content:center;

color:#4E688C;
text-decoration:none;

border-radius:10px;

transition:all .2s ease;

}

.back-link:hover{

background:#eef4ff;

color:#0d6efd;

}

.back-link:active{

background:#dbeafe;

transform:scale(.95);

}
.content{

    padding:20px;
}

.laporan-card{

display:flex;

gap:14px;

background:white;

border-radius:20px;

padding:14px;

margin-bottom:16px;

box-shadow:0 6px 18px rgba(0,0,0,.08);

transition:all .2s ease;

}

.laporan-card:hover{

background:#f8fbff;

box-shadow:0 10px 22px rgba(0,0,0,.12);

transform:translateY(-2px);

}

.laporan-card:active{

background:#eef4ff;

transform:scale(.98);

}

.laporan-img{

width:90px;

height:90px;

object-fit:cover;

border-radius:14px;

flex-shrink:0;

}

.laporan-content{

flex:1;

min-width:0;

}

.laporan-deskripsi{

margin:8px 0;

color:#6c757d;

overflow-wrap:anywhere;

font-size:14px;

}

.badge-status{

padding:6px 12px;

border-radius:10px;

font-size:12px;

color:white;

font-weight:600;

}

.badge-status.primary{

background:#0d6efd;

}

.badge-status.success{

background:#198754;

}

.badge-status.secondary{

background:#6c757d;

}

.badge-status.warning{

background:#ffc107;

color:#212529;

}

.badge-status.danger{

background:#dc3545;

}


.badge{

font-size:.75rem;

padding:.45rem .7rem;

border-radius:10px;

}

.btn-light{

width:40px;

height:40px;

display:flex;

justify-content:center;

align-items:center;

}

.text-muted{

line-height:1.5;

}
.laporan-deskripsi{
    .laporan-deskripsi{
    overflow-wrap:anywhere;
}
}


.laporan-content{

flex:1;
min-width:0;   /* penting agar teks bisa mengecil dan membungkus */

}
.detail-img{

width:100%;

height:220px;

object-fit:cover;

border-radius:20px;

}

.detail-card{

background:white;

border-radius:18px;

padding:18px;

box-shadow:0 5px 15px rgba(0,0,0,.08);

}

#map{

width:100%;

height:250px;

border-radius:14px;

margin-top:15px;

}

/* laporan saya */
.status-filter{

display:flex;

gap:10px;

overflow-x:auto;

overflow-y:hidden;

white-space:nowrap;

cursor:grab;

user-select:none;

-webkit-overflow-scrolling:touch;

scrollbar-width:none;

}

.status-filter::-webkit-scrollbar{

display:none;

}

.status-filter.dragging{

cursor:grabbing;

}

.status-chip{

flex:0 0 auto;

border:none;

border-radius:999px;

padding:10px 18px;

background:#F5F7FB;

color:#5C6F87;

font-size:13px;

font-weight:600;

transition:.2s;

}

.status-chip.active{

background:#4E8FDF;

color:white;

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

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- leaflet -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@yield('scripts')
</body>
</html>