@extends('layouts.mobile')

@section('title','Peta Kerusakan Jalan')

@section('content')

<style>
#map{
    height:65vh;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 3px 12px rgba(0,0,0,.15);
}

.popup-img{
    width:100%;
    height:120px;
    object-fit:cover;
    border-radius:8px;
    margin-bottom:10px;
}

.leaflet-control-layers{
    border-radius:10px !important;
    overflow:hidden;
}
.leaflet-control-layers-expanded{
    padding:6px 8px !important;
    font-size:11px;
    min-width:125px;
}

.leaflet-control-layers-base label,
.leaflet-control-layers-overlays label{
    font-size:11px;
    margin-bottom:2px;
}

.leaflet-control-layers-toggle{
    width:30px;
    height:30px;
}
/* ==========================
   POPUP LAPORAN
========================== */

.leaflet-popup-content-wrapper{
    padding:0 !important;
    border-radius:16px !important;
    overflow:hidden;
}

.leaflet-popup-content{
    width:260px !important;
    margin:0 !important;
}

.leaflet-popup-tip{
    box-shadow:none;
}

.popup-card{
    background:#fff;
    overflow:hidden;
}

.popup-image-wrapper{
    position:relative;
    width:100%;
    height:150px;
    overflow:hidden;
}

.popup-image{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

.popup-body{
    padding:14px 15px 15px;
}

.popup-title{
    font-size:15px;
    font-weight:700;
    color:#1f2937;
    margin:0 0 8px;
    line-height:1.35;
}

.popup-address{
    display:flex;
    align-items:flex-start;
    gap:7px;
    font-size:12px;
    color:#6b7280;
    line-height:1.4;
    margin-bottom:12px;
}

.popup-address i{
    color:#dc3545;
    margin-top:2px;
}

.popup-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding-top:10px;
    border-top:1px solid #eef0f3;
}

.popup-status{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:5px 9px;
    border-radius:20px;
    font-size:11px;
    font-weight:600;
}

.popup-date{
    font-size:11px;
    color:#9ca3af;
    display:flex;
    align-items:center;
    gap:4px;
}

.filter-card{
    border:none;
    border-radius:12px;
}

/* cluster */
/* Cluster kecil */
.marker-cluster-small {
    background: rgba(220, 53, 69, 0.25) !important;
}

.marker-cluster-small div {
    background: #dc3545 !important;
    color: #fff;
}

/* Cluster sedang */
.marker-cluster-medium {
    background: rgba(220, 53, 69, 0.35) !important;
}

.marker-cluster-medium div {
    background: #dc3545 !important;
    color: #fff;
}

/* Cluster besar */
.marker-cluster-large {
    background: rgba(220, 53, 69, 0.45) !important;
}

.marker-cluster-large div {
    background: #dc3545 !important;
    color: #fff;
}
</style>

<div class="mb-2">
    <h3 class="fw-bold mb-1">
        <i class></i>
        Peta Kerusakan Jalan
    </h3>
    <small class="text-muted">
        Visualisasi lokasi laporan kerusakan jalan di Kabupaten Wonogiri
    </small>
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


<div id="map"></div>

@endsection

@section('scripts')
<script>



// ==========================
// BASEMAP
// ==========================

var osm = L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
    attribution:'&copy; OpenStreetMap'
});

var satellite = L.tileLayer(
'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
{
    attribution:'Tiles &copy; Esri'
});

// Basemap awal
var map = L.map('map');
osm.addTo(map);

var batasWonogiri = L.geoJSON(
    JSON.parse(@json($admin->geojson)),
    {
        style:{
            color:"#2563eb",
            weight:3,
            fillOpacity:0
        }
    }
).addTo(map);

@if(isset($lat) && isset($lng))

map.setView([{{ $lat }}, {{ $lng }}],17);

@else

map.fitBounds(batasWonogiri.getBounds());
map .setZoom(10);

@endif
// ==========================
// CLUSTER PER STATUS
// ==========================
var markers = L.markerClusterGroup({

maxClusterRadius: function (zoom) {

    if (zoom <= 10) return 35;

    if (zoom <= 12) return 25;

    if (zoom <= 14) return 18;

    if (zoom <= 16) return 10;

    return 5;
},
    disableClusteringAtZoom: 15,
    spiderfyOnMaxZoom: true,
    showCoverageOnHover: false,
    zoomToBoundsOnClick: true
});
map.addLayer(markers);
    
    @if($laporans->isEmpty() && !request()->filled('id'))
    
    L.popup({
        closeButton:false,
        autoClose:false,
        closeOnClick:false
    })
    .setLatLng(batasWonogiri.getBounds().getCenter())
    .setContent(`
        <div style="text-align:center">
            <b>Pilih periode terlebih dahulu</b><br>
            <small>Silakan pilih bulan dan tahun untuk menampilkan data.</small>
        </div>
    `)
    .openOn(map);
    @endif
    
// ==========================
// LAYER TITIK
// ==========================
var terkirimMarkers = L.featureGroup.subGroup(markers);
var diprosesMarkers = L.featureGroup.subGroup(markers);
var diteruskanMarkers = L.featureGroup.subGroup(markers);
var selesaiMarkers = L.featureGroup.subGroup(markers);


// ==========================
// LAYER GARIS
// ==========================
var terkirimLines = L.layerGroup();
var diprosesLines = L.layerGroup();
var diteruskanLines = L.layerGroup();
var selesaiLines = L.layerGroup();


// ==========================
// GABUNG PER STATUS
// ==========================
var terkirimLayer = L.layerGroup([
    terkirimMarkers,
    terkirimLines
]);

var diprosesLayer = L.layerGroup([
    diprosesMarkers,
    diprosesLines
]);

var diteruskanLayer = L.layerGroup([
    diteruskanMarkers,
    diteruskanLines
]);

var selesaiLayer = L.layerGroup([
    selesaiMarkers,
    selesaiLines
]);

const LINE_DETAIL_ZOOM = 15;

// Menyimpan pasangan marker ringkas + garis asli
var laporanGarisLayers = [];


// ==========================
// MARKER
// ==========================

@foreach($laporans as $laporan)
var statusLaporan = @json($laporan->status);

var warnaStatus = {
    'Terkirim': '#6c757d',
    'Diproses': '#f59e0b',
    'Diteruskan': '#0d6efd',
    'Selesai': '#198754'
}[statusLaporan] || '#6c757d';

var iconHtml='';
@if($laporan->status=="Terkirim")

iconHtml=`
<div style="
width:40px;
height:40px;
background:#6c757d;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:18px;
color:white;
border:3px solid white;
box-shadow:0 2px 8px rgba(0,0,0,.35);
">
<i class="fa-solid fa-paper-plane"></i>
</div>
`;

@elseif($laporan->status=="Diproses")

iconHtml=`
<div style="
width:40px;
height:40px;
background:#f59e0b;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:18px;
color:white;
border:3px solid white;
box-shadow:0 2px 8px rgba(0,0,0,.35);
">
<i class="fa-solid fa-hourglass-start"></i></div>
`;

@elseif($laporan->status=="Diteruskan")

iconHtml=`
<div style="
width:40px;
height:40px;
background:#0d6efd;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:18px;
color:white;
border:3px solid white;
box-shadow:0 2px 8px rgba(0,0,0,.35);
">
<i class="fa-solid fa-share"></i>
</div>
`;

@else

iconHtml=`
<div style="
width:40px;
height:40px;
background:#198754;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:18px;
color:white;
border:3px solid white;
box-shadow:0 2px 8px rgba(0,0,0,.35);
">
<i class="fa-solid fa-circle-check"></i>
</div>
`;

@endif
var layerLaporan;
var isGaris = false;

@if(
    $laporan->tipe_lokasi === 'garis'
    && !empty($laporan->geom_garis_geojson)
)

    // ==========================
    // LAPORAN GARIS
    // ==========================
    isGaris = true;

    // Garis asli
    layerLaporan = L.geoJSON(
        JSON.parse(@json($laporan->geom_garis_geojson)),
        {
            style: {
                color: warnaStatus,
                weight: 6,
                opacity: 0.9,
                lineCap: 'round',
                lineJoin: 'round'
            }
        }
    );

    // Marker midpoint untuk tampilan saat zoom jauh
    var markerRingkas = L.marker(
        [
            {{ $laporan->latitude }},
            {{ $laporan->longitude }}
        ],
        {
            icon: L.divIcon({
                html: iconHtml,
                className: '',
                iconSize: [40,40],
                iconAnchor: [20,40],
                popupAnchor: [0,-38]
            })
        }
    );

@else


    // ==========================
    // LAPORAN TITIK
    // ==========================
      var markerRingkas = null;
    layerLaporan = L.marker(
        [
            {{ $laporan->latitude }},
            {{ $laporan->longitude }}
        ],
        {
            icon: L.divIcon({
                html: iconHtml,
                className: '',
                iconSize: [40,40],
                iconAnchor: [20,40],
                popupAnchor: [0,-38]
            })
        }
    );

@endif

var popupContent = `
<div class="popup-card">

    <div class="popup-image-wrapper">
        <img
            class="popup-image"
            src="{{ asset('storage/'.$laporan->foto) }}"
            alt="Foto laporan">
    </div>

    <div class="popup-body">

        <h6 class="popup-title">
            {{ $laporan->judul }}
        </h6>

        <div class="popup-address">
            <i class="fa-solid fa-location-dot"></i>

            <span>
                {{ $laporan->alamat }}
            </span>
        </div>

        <div class="popup-footer">

            <span
                class="popup-status"
                style="
                    @if($laporan->status == 'Terkirim')
                        background:#f1f3f5;
                        color:#6c757d;
                    @elseif($laporan->status == 'Diproses')
                        background:#fff3cd;
                        color:#946200;
                    @elseif($laporan->status == 'Diteruskan')
                        background:#e7f1ff;
                        color:#0d6efd;
                    @elseif($laporan->status == 'Selesai')
                        background:#e8f5ee;
                        color:#198754;
                    @endif
                "
            >

                @if($laporan->status == 'Terkirim')
                    <i class="fa-solid fa-paper-plane"></i>

                @elseif($laporan->status == 'Diproses')
                    <i class="fa-solid fa-hourglass-start"></i>

                @elseif($laporan->status == 'Diteruskan')
                    <i class="fa-solid fa-share"></i>

                @elseif($laporan->status == 'Selesai')
                    <i class="fa-solid fa-circle-check"></i>
                @endif

                {{ $laporan->status }}

            </span>

            <span class="popup-date">
                <i class="fa-regular fa-calendar"></i>
                {{ $laporan->created_at->format('d M Y, H:i') }} WIB
            </span>

        </div>

    </div>

</div>
`;

layerLaporan.bindPopup(popupContent);

if (markerRingkas) {
    markerRingkas.bindPopup(popupContent);
}


if (statusLaporan === 'Terkirim') {

    if (isGaris) {

        laporanGarisLayers.push({
            marker: markerRingkas,
            garis: layerLaporan,
            markerGroup: terkirimMarkers,
            lineGroup: terkirimLines
        });

    } else {

        terkirimMarkers.addLayer(layerLaporan);

    }

}
else if (statusLaporan === 'Diproses') {

    if (isGaris) {

        laporanGarisLayers.push({
            marker: markerRingkas,
            garis: layerLaporan,
            markerGroup: diprosesMarkers,
            lineGroup: diprosesLines
        });

    } else {

        diprosesMarkers.addLayer(layerLaporan);

    }

}
else if (statusLaporan === 'Diteruskan') {

    if (isGaris) {

        laporanGarisLayers.push({
            marker: markerRingkas,
            garis: layerLaporan,
            markerGroup: diteruskanMarkers,
            lineGroup: diteruskanLines
        });

    } else {

        diteruskanMarkers.addLayer(layerLaporan);

    }

}
else if (statusLaporan === 'Selesai') {

    if (isGaris) {

        laporanGarisLayers.push({
            marker: markerRingkas,
            garis: layerLaporan,
            markerGroup: selesaiMarkers,
            lineGroup: selesaiLines
        });

    } else {

        selesaiMarkers.addLayer(layerLaporan);

    }

}

@if(isset($id))

@if($laporan->id==$id)

setTimeout(function(){

if (isGaris) {

    map.fitBounds(
        layerLaporan.getBounds(),
        {
            padding: [30,30],
            maxZoom: 17
        }
    );

    layerLaporan.eachLayer(function(layer) {
        layer.openPopup();
    });

} else {

    layerLaporan.openPopup();

    map.setView(
        [
            {{ $laporan->latitude }},
            {{ $laporan->longitude }}
        ],
        17
    );

}

},500);

@endif

@endif
@endforeach

function updateTampilanGaris() {

    var zoom = map.getZoom();

    laporanGarisLayers.forEach(function(item) {

        if (zoom >= LINE_DETAIL_ZOOM) {

            // Zoom dekat → tampilkan garis
            item.markerGroup.removeLayer(item.marker);

            if (!item.lineGroup.hasLayer(item.garis)) {
                item.lineGroup.addLayer(item.garis);
            }

        } else {

            // Zoom jauh → tampilkan marker midpoint
            item.lineGroup.removeLayer(item.garis);

            if (!item.markerGroup.hasLayer(item.marker)) {
                item.markerGroup.addLayer(item.marker);
            }

        }

    });

}
map.on('zoomend', updateTampilanGaris);
updateTampilanGaris();

// ==========================
// TAMPILKAN CLUSTER
// ==========================

@if(request()->filled('id'))
    map.addLayer(terkirimLayer);
@endif
map.addLayer(diprosesLayer);
map.addLayer(diteruskanLayer);
map.addLayer(selesaiLayer);
// ==========================
// LEGENDA
// ==========================

// ==========================
// LEGENDA
// ==========================

L.control.layers(
{
    "OpenStreetMap": osm,
    "Satelit": satellite
},
{
  
    "Diproses": diprosesLayer,
    "Diteruskan": diteruskanLayer,
    "Selesai": selesaiLayer
},
{
    collapsed: false,
    position: 'bottomright'
}
).addTo(map);


// ==========================
// CUSTOM TAMPILAN LEGENDA
// ==========================

setTimeout(function () {

    var base = document.querySelector('.leaflet-control-layers-base');
    var over = document.querySelector('.leaflet-control-layers-overlays');

    // Judul Peta Dasar
    if(base){
        base.insertAdjacentHTML(
            'afterbegin',
            '<div style="font-weight:600;margin-bottom:8px;">Peta Dasar</div>'
        );
    }

    // Judul Status Laporan
    if(over){

        over.insertAdjacentHTML(
            'afterbegin',
            '<div style="font-weight:600;margin:10px 0 8px;">Status Laporan</div>'
        );

        var labels = over.querySelectorAll('label');

        labels.forEach(function(label){

            var text = label.textContent.trim();

            var icon = '';
            var bg = '';

           
            if(text === 'Diproses'){

                icon = 'fa-hourglass-start';
                bg = '#f59e0b';

            }
            //  else if(text === 'Terkirim'){

            //     icon = 'fa-paper-plane';
            //     bg = '#6c757d';

            // }
            else if(text === 'Diteruskan'){

                icon = 'fa-share';
                bg = '#0d6efd';

            }
            else if(text === 'Selesai'){

                icon = 'fa-circle-check';
                bg = '#198754';

            }

            if(icon){

                var iconElement = document.createElement('span');

            iconElement.style.cssText = `
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:20px;
    height:20px;
    margin-left:6px;
    margin-right:7px;
    border-radius:50%;
    background:${bg};
    color:white;
    font-size:10px;
    vertical-align:middle;
`;

                iconElement.innerHTML =
                    `<i class="fa-solid ${icon}"></i>`;

                // Tambahkan ikon setelah checkbox
                var input = label.querySelector('input');

                if(input){
                    input.insertAdjacentElement(
                        'afterend',
                        iconElement
                    );
                }

            }

        });

    }

},100);
</script>

@endsection