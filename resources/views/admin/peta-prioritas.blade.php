@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-md-3">
        <div class="card stat-card text-center h-100">                <div class="card-body">
                    <i class="bi bi-geo-alt-fill text-primary fs-2"></i>
                    <h6 class="mt-2">Total Laporan</h6>
                    <h2 id="statTotal">0</h2>
                    </div>
            </div>
        </div>

        <div class="col-md-3">
        <div class="card stat-card text-center h-100">                <div class="card-body">
<div class="priority-icon priority-high">
    <i class="bi bi-exclamation-triangle-fill"></i>
</div>
<h6 class="mt-2">Prioritas Tinggi</h6>
                    <h2 id="statTinggi">0</h2>
                    </div>
            </div>
        </div>

        <div class="col-md-3">
        <div class="card stat-card text-center h-100">                <div class="card-body">
<div class="priority-icon priority-medium">
    <i class="bi bi-exclamation-circle-fill"></i>
</div>
<h6 class="mt-2">Prioritas Sedang</h6>
                    <h2 id="statSedang">0</h2>
                    </div>
            </div>
        </div>

        <div class="col-md-3">
        <div class="card stat-card text-center h-100">                <div class="card-body">
<div class="priority-icon priority-low">
    <i class="bi bi-check-circle-fill"></i>
</div>
<h6 class="mt-2">Prioritas Rendah</h6>
                    <h2 id="statRendah">0</h2>
                    </div>
            </div>
        </div>

    </div>
    <div class="alert alert-warning border-0 shadow-sm mt-3 mb-3">
    <i class="bi bi-info-circle-fill me-2"></i>
    <strong>Catatan:</strong>
    Hasil analisis prioritas ini merupakan rekomendasi awal yang disusun berdasarkan parameter kedekatan fasilitas umum, jenis jalan, dan kepadatan penduduk. Hasil analisis dapat dijadikan sebagai bahan pertimbangan pendukung dalam menentukan prioritas penanganan kerusakan jalan, dengan tetap mempertimbangkan hasil survei lapangan serta kebijakan instansi terkait.
</div>
<div class="card shadow-sm">

{{-- HEADER --}}
<div class="card-header bg-white py-4 px-4">

    @php
        $bulanSekarang = now()->month;
        $tahunSekarang = now()->year;
    @endphp

   <div class="d-flex justify-content-between align-items-start gap-3">

    {{-- Judul --}}
    <div class="map-title-wrapper">

        <h3 class="mb-1">
            <b>Peta Prioritas Penanganan Kerusakan Jalan</b>
        </h3>

        <p class="text-muted mb-0">
            Visualisasi hasil analisis prioritas perbaikan jalan
        </p>

    </div>

    {{-- Filter --}}
    <div class="filter-box flex-shrink-0">

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

        $bulanSekarang = request('bulan', now()->month);
        $tahunSekarang = request('tahun', now()->year);
    @endphp

    <div class="filter-item">

        <label>
            <i class="bi bi-calendar3"></i>
            Periode
        </label>

        <div class="d-flex gap-2">

            <select
                id="filterBulan"
                class="form-select">

                @foreach($bulanList as $key => $nama)

                    <option
                        value="{{ $key }}"
                        {{ $bulanSekarang == $key ? 'selected' : '' }}>

                        {{ $nama }}

                    </option>

                @endforeach

            </select>

            <select
                id="filterTahun"
                class="form-select">

                @for($i = now()->year; $i <= now()->year + 3; $i++)

                    <option
                        value="{{ $i }}"
                        {{ $tahunSekarang == $i ? 'selected' : '' }}>

                        {{ $i }}

                    </option>

                @endfor

            </select>

        </div>

    </div>

    <div class="filter-item">

        <label>
            <i class="bi bi-funnel"></i>
            Prioritas
        </label>

        <select
            id="filterPrioritas"
            class="form-select">

            <option value="Semua">Semua Prioritas</option>
            <option value="Tinggi">Tinggi</option>
            <option value="Sedang">Sedang</option>
            <option value="Rendah">Rendah</option>

        </select>

    </div>
    </div>
</div>

{{-- BODY --}}
<div class="card-body p-4 pt-0">

    <div id="map"></div>

</div>

</div>
@endsection

@section('scripts')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.5/leaflet.awesome-markers.js"></script>
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.5/leaflet.awesome-markers.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"> -->

<script>


var map = L.map('map').setView([-7.82,110.92],11);

var osm = L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
    attribution:'© OpenStreetMap'
});

var satellite = L.tileLayer(
'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
{
    attribution:'Tiles © Esri'
});

osm.addTo(map);
var laporan = @json($laporan);
var batasAdmin = {!! $admin->geojson !!};
var adminLayer = L.geoJSON(batasAdmin, {

style: {
    color: '#2563eb',
    weight: 2,
    fillColor: '#60a5fa',
    fillOpacity: 0.08
}

}).addTo(map);

const bounds = adminLayer.getBounds();

map.fitBounds(bounds, {
    animate: false
});

map.setMaxBounds(bounds.pad(0.30));

// layer control
L.control.layers(
{
    "OpenStreetMap": osm,
    "Satelit": satellite
},
{
    "Batas Kabupaten": adminLayer
},
{
    collapsed:false,
    position:'topright'
}).addTo(map);
setTimeout(function(){

var base = document.querySelector('.leaflet-control-layers-base');

if(base){

    base.insertAdjacentHTML(
        'beforeend',
        `
        <hr style="margin:10px 0">

        <div style="font-weight:600;margin-bottom:8px">
            Legenda
        </div>

       <div style="display:flex;align-items:center;margin-bottom:7px">
    <span class="legend-priority legend-high">
        <i class="bi bi-exclamation-triangle-fill"></i>
    </span>
    Prioritas Tinggi
</div>

<div style="display:flex;align-items:center;margin-bottom:7px">
    <span class="legend-priority legend-medium">
        <i class="bi bi-exclamation-circle-fill"></i>
    </span>
    Prioritas Sedang
</div>

<div style="display:flex;align-items:center">
    <span class="legend-priority legend-low">
        <i class="bi bi-check-circle-fill"></i>
    </span>
    Prioritas Rendah
</div>
        `
    );

}

},100);

var laporanLayers = [];

const LINE_DETAIL_ZOOM = 15;

const redIcon = L.divIcon({
    className: '',
    html: `
        <div style="
            width:34px;
            height:34px;
            border-radius:50%;
            background:#dc3545;
            border:3px solid white;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:0 2px 8px rgba(0,0,0,.35);
        ">
            <i class="bi bi-exclamation-triangle-fill"
               style="color:white;font-size:18px"></i>
        </div>
    `,
    iconSize:[34,34],
    iconAnchor:[17,17]
});
const yellowIcon = L.divIcon({
    className:'',
    html:`
        <div style="
            width:34px;
            height:34px;
            border-radius:50%;
            background:#ffc107;
            border:3px solid white;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:0 2px 8px rgba(0,0,0,.35);
        ">
            <i class="bi bi-exclamation-circle-fill"
               style="color:white;font-size:18px"></i>
        </div>
    `,
    iconSize:[34,34],
    iconAnchor:[17,17]
});

const greenIcon = L.divIcon({
    className:'',
    html:`
        <div style="
            width:34px;
            height:34px;
            border-radius:50%;
            background:#198754;
            border:3px solid white;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:0 2px 8px rgba(0,0,0,.35);
        ">
            <i class="bi bi-check-circle-fill"
               style="color:white;font-size:18px"></i>
        </div>
    `,
    iconSize:[34,34],
    iconAnchor:[17,17]
});
laporan.forEach(function(item){

    if(item.analisis_prioritas == null){
        return;
    }

    const kategori =
        item.analisis_prioritas.kategori_prioritas;


    // ==========================
    // WARNA & ICON PRIORITAS
    // ==========================

    let icon = greenIcon;
    let warnaPrioritas = '#198754';

    if(kategori === 'Tinggi'){

        icon = redIcon;
        warnaPrioritas = '#dc3545';

    }
    else if(kategori === 'Sedang'){

        icon = yellowIcon;
        warnaPrioritas = '#ffc107';

    }


    // ==========================
    // MARKER RINGKAS
    // ==========================

    const markerRingkas = L.marker(
        [
            item.latitude,
            item.longitude
        ],
        {
            icon: icon
        }
    );


    // ==========================
    // GARIS
    // ==========================

    let garisLayer = null;

    const isGaris =
        item.tipe_lokasi === 'garis'
        && item.geom_garis_geojson;


    if(isGaris){

        const geojsonGaris =
            typeof item.geom_garis_geojson === 'string'
                ? JSON.parse(item.geom_garis_geojson)
                : item.geom_garis_geojson;


        garisLayer = L.geoJSON(
            geojsonGaris,
            {
                style:{
                    color: warnaPrioritas,
                    weight: 6,
                    opacity: 0.9,
                    lineCap: 'round',
                    lineJoin: 'round'
                }
            }
        );

    }


    // ==========================
    // BADGE PRIORITAS
    // ==========================

    let badge = '';

    if(kategori === 'Tinggi'){

        badge =
            '<span class="badge bg-danger fs-6">' +
            'Prioritas Tinggi' +
            '</span>';

    }
    else if(kategori === 'Sedang'){

        badge =
            '<span class="badge bg-warning text-dark fs-6">' +
            'Prioritas Sedang' +
            '</span>';

    }
    else{

        badge =
            '<span class="badge bg-success fs-6">' +
            'Prioritas Rendah' +
            '</span>';

    }


    // ==========================
    // POPUP
    // ==========================

    const popupContent = `

        <div class="popup-card">

            <div class="popup-header">

                <div>

                    <h5>${item.judul}</h5>

                    <span class="badge bg-primary">
                        ${item.status}
                    </span>

                </div>

            </div>

            <p class="popup-desc">
                ${item.deskripsi ?? '-'}
            </p>

            <div class="my-2 border-top"></div>

            <h6 class="mb-3">
                <i class="bi bi-clipboard-data"></i>
                Hasil Analisis
            </h6>

            <table class="table table-sm align-middle mb-3">

                <tr>
                    <td colspan="2">

                        <b>🏥 Kedekatan Fasilitas Umum</b><br>

                        <small class="text-muted">
                            Jarak fasilitas umum :
                            ${item.analisis_prioritas.jarak_fasum ?? '-'}
                        </small><br>

                        <span class="badge bg-success mt-1">
                            Skor ${item.analisis_prioritas.p1_fasum}
                        </span>

                    </td>
                </tr>

                <tr>
                    <td colspan="2">

                        <b>🛣️ Jenis Jalan</b><br>

                        <small class="text-muted">
                            ${item.analisis_prioritas.jenis_jalan ?? '-'}
                        </small><br>

                        <span class="badge bg-primary mt-1">
                            Skor ${item.analisis_prioritas.p2_jalan}
                        </span>

                    </td>
                </tr>

                <tr>
                    <td colspan="2">

                        <b>👥 Kepadatan Penduduk</b><br>

                        <small class="text-muted">
                            ${item.analisis_prioritas.kategori_kepadatan ?? '-'}
                        </small><br>

                        <span class="badge bg-warning text-dark mt-1">
                            Skor ${item.analisis_prioritas.p3_kepadatan}
                        </span>

                    </td>
                </tr>

            </table>

            <div class="score-box">

                <div>

                    <small>Total Skor</small>

                    <h3>
                        ${item.analisis_prioritas.skor_prioritas}
                    </h3>

                </div>

                <div>

                    <small>Prioritas</small>

                    <br>

                    ${badge}

                </div>

            </div>

            <div class="text-center mt-2">

                <a
                    href="/admin/laporan/${item.id}"
                    class="btn-detail">

                    <i class="bi bi-eye-fill"></i>

                    Lihat Detail

                </a>

            </div>

        </div>
    `;


    const popupOptions = {

        maxWidth: 320,
        autoPan: true,
        autoPanPadding: [40,40],
        autoPanPaddingTopLeft: [40,120],
        autoPanPaddingBottomRight: [40,40],
        keepInView: true

    };


    markerRingkas.bindPopup(
        popupContent,
        popupOptions
    );


    if(garisLayer){

        garisLayer.bindPopup(
            popupContent,
            popupOptions
        );

    }


    // ==========================
    // DATA FILTER
    // ==========================

    const tanggal =
        new Date(item.created_at);


    laporanLayers.push({

        marker: markerRingkas,

        garis: garisLayer,

        isGaris: !!garisLayer,

        kategori: kategori,

        bulan:
            tanggal.getMonth() + 1,

        tahun:
            tanggal.getFullYear()

    });

});



// ==========================
// CEK FILTER
// ==========================

function cocokFilter(item){

    const bulan =
        Number(
            document
                .getElementById("filterBulan")
                .value
        );

    const tahun =
        Number(
            document
                .getElementById("filterTahun")
                .value
        );

    const kategori =
        document
            .getElementById("filterPrioritas")
            .value;


    if(
        kategori !== "Semua"
        && item.kategori !== kategori
    ){
        return false;
    }


    if(item.bulan !== bulan){
        return false;
    }


    if(item.tahun !== tahun){
        return false;
    }


    return true;

}



// ==========================
// TAMPILKAN LAPORAN
// ==========================

function renderLaporan(){

    const zoom = map.getZoom();


    laporanLayers.forEach(function(item){

        // bersihkan dahulu
        map.removeLayer(item.marker);

        if(item.garis){
            map.removeLayer(item.garis);
        }


        // tidak sesuai filter
        if(!cocokFilter(item)){
            return;
        }


        // Garis + zoom dekat
        if(
            item.isGaris
            && zoom >= LINE_DETAIL_ZOOM
        ){

            map.addLayer(item.garis);

        }

        // Titik atau zoom jauh
        else{

            map.addLayer(item.marker);

        }

    });

}



// ==========================
// STATISTIK
// ==========================

function updateStatistik(){

    const bulan =
        Number(
            document
                .getElementById("filterBulan")
                .value
        );

    const tahun =
        Number(
            document
                .getElementById("filterTahun")
                .value
        );


    let total = 0;
    let tinggi = 0;
    let sedang = 0;
    let rendah = 0;


    laporanLayers.forEach(function(item){

        if(
            item.bulan === bulan
            && item.tahun === tahun
        ){

            total++;


            if(item.kategori === "Tinggi"){

                tinggi++;

            }
            else if(item.kategori === "Sedang"){

                sedang++;

            }
            else if(item.kategori === "Rendah"){

                rendah++;

            }

        }

    });


    document
        .getElementById("statTotal")
        .textContent = total;

    document
        .getElementById("statTinggi")
        .textContent = tinggi;

    document
        .getElementById("statSedang")
        .textContent = sedang;

    document
        .getElementById("statRendah")
        .textContent = rendah;

}



// ==========================
// FILTER
// ==========================

function filterMarker(){

    renderLaporan();

    updateStatistik();

}



// ==========================
// EVENT FILTER
// ==========================

document
    .getElementById("filterBulan")
    .addEventListener(
        "change",
        filterMarker
    );


document
    .getElementById("filterTahun")
    .addEventListener(
        "change",
        filterMarker
    );


document
    .getElementById("filterPrioritas")
    .addEventListener(
        "change",
        filterMarker
    );



// ==========================
// EVENT ZOOM
// ==========================

map.on(
    'zoomend',
    renderLaporan
);


// Tampilkan pertama kali
filterMarker();
</script>

@endsection