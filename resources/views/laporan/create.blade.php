@extends('layouts.mobile')

@section('title', 'Buat Laporan')

@section('content')

<div class="container py-3">

<div class="card info-card border-0 shadow-sm mb-4 position-relative overflow-hidden">
    <div class="card-body p-4">

        <i class="bi bi-cone-striped position-absolute"
           style="right:20px; top:18px; font-size:48px; opacity:.15;"></i>

        <h4 class="fw-bold mb-2">
            <i class="bi bi-pencil-square me-2"></i>
            Buat Laporan
        </h4>

        <p class="mb-0">
            Laporkan kerusakan jalan dengan mengisi data secara lengkap agar laporan dapat diproses.
        </p>

    </div>
</div> 

<form id="formLaporan"
      action="{{ route('laporan.store') }}"
      method="POST"
      enctype="multipart/form-data">
         @csrf

        <div class="mb-3">
            <label class="form-label">Judul Laporan</label>
            <input
            type="text"
            name="judul"
            value="{{ old('judul') }}"
            class="form-control @error('judul') is-invalid @enderror"
            placeholder="Contoh: Jalan Berlubang di Depan Pasar Krisak">
            @error('judul')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror      
        </div>

        <div class="mb-3">
        <label class="form-label">Deskripsi</label>
    
        <textarea
            name="deskripsi"
            rows="4"
            class="form-control @error('deskripsi') is-invalid @enderror"
            placeholder="Contoh: Terdapat lubang cukup dalam di tengah jalan yang membahayakan pengendara, terutama saat malam hari.">{{ old('deskripsi') }}</textarea>
    
        @error('deskripsi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
</div>

      

        <div class="mb-3">

        <label class="form-label fw-semibold">
            Foto Kerusakan Jalan
        </label>
        
        <input
        type="file"
        id="foto"
        name="foto"
        accept="image/*"
        class="d-none">

        <div id="uploadCard" class="card border-2 border-dashed text-center p-4" style="cursor:pointer;">
    
            <div class="mb-2">
                <i class="bi bi-camera-fill fs-1 text-primary"></i>
            </div>
    
            <h6 class="mb-1">Tambahkan Foto</h6>
    
            <small class="text-muted">
                Ketuk untuk mengambil foto atau memilih dari galeri
            </small>
    
        </div>

    @error('foto')
        <small class="text-danger d-block mt-2">
            {{ $message }}
        </small>
    @enderror

    <div class="mt-3 d-none" id="previewContainer">

        <img
            id="preview"
            class="img-fluid rounded shadow-sm"
            style="width:100%; max-height:250px; object-fit:cover;">

        <button
            type="button"
            class="btn btn-outline-secondary btn-sm w-100 mt-2"
            id="gantiFoto">

            <i class="bi bi-arrow-repeat"></i>
            Ganti Foto

        </button>

    </div>

</div>


     {{-- ==========================
     Jenis Lokasi
========================== --}}
<div class="mb-3">
    <label class="form-label fw-semibold">
        Bentuk Kerusakan Jalan
    </label>

    <div class="btn-group w-100" role="group">

        <input
            type="radio"
            class="btn-check"
            name="tipe_lokasi"
            id="tipeTitik"
            value="titik"
            checked>

        <label class="btn btn-outline-primary" for="tipeTitik">
            <i class="bi bi-geo-alt-fill me-1"></i>
            Titik
        </label>

        <input
            type="radio"
            class="btn-check"
            name="tipe_lokasi"
            id="tipeGaris"
            value="garis">

        <label class="btn btn-outline-primary" for="tipeGaris">
            <i class="bi bi-bezier2 me-1"></i>
            Garis
        </label>

    </div>

    <small class="text-muted d-block mt-2" id="petunjukLokasi">
        Pilih titik lokasi kerusakan pada peta.
    </small>
</div>
<div class="mb-3">

    <button
        class="info-toggle w-100 d-flex justify-content-between align-items-center"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#infoPelaporan"
        aria-expanded="false"
        aria-controls="infoPelaporan">

        <span>
            <i class="bi bi-info-circle-fill me-2"></i>
            Informasi Pelaporan
        </span>

        <i class="bi bi-chevron-down info-chevron"></i>

    </button>

    <div class="collapse mt-2" id="infoPelaporan">

        <div class="info-content">

            <div class="info-item">
                <div class="info-icon">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>

                <div>
                    <div class="fw-semibold">
                        Akurasi Lokasi GPS
                    </div>

                    <small class="text-muted">
                        Lokasi yang diperoleh melalui GPS dapat mengalami
                        pergeseran akibat tingkat akurasi perangkat dan kondisi
                        lingkungan. Pastikan lokasi laporan sudah sesuai dan
                        sesuaikan secara manual pada peta apabila diperlukan.
                    </small>
                </div>
            </div>

            <div class="info-divider"></div>

            <div class="info-item">
                <div class="info-icon">
                    <i class="bi bi-signpost-split-fill"></i>
                </div>

                <div>
                    <div class="fw-semibold">
                        Cakupan Jalan
                    </div>

                    <small class="text-muted">
                        Laporan yang diproses difokuskan pada kerusakan jalan
                        kabupaten yang menjadi kewenangan Pemerintah Kabupaten
                        Wonogiri.
                    </small>
                </div>
            </div>

        </div>

    </div>

</div>

{{-- ==========================
     Tombol Lokasi GPS
========================== --}}
<div class="mb-3" id="containerLokasiSaya">

    <button
        type="button"
        class="btn btn-primary w-100"
        id="btnLokasi">

        <i class="bi bi-geo-alt-fill"></i>
        Gunakan Lokasi Saya

    </button>

</div>


{{-- ==========================
     Kontrol Garis
========================== --}}
<div
    class="mb-3 d-none"
    id="kontrolGaris">

    <div class="alert alert-light border mb-2">
        <small>
            Ketuk minimal dua titik pada peta untuk menggambar
            ruas jalan yang mengalami kerusakan.
        </small>
    </div>

    <div class="d-flex gap-2">

        <button
            type="button"
            class="btn btn-primary flex-fill"
            id="btnSelesaiGaris"
            disabled>

            <i class="bi bi-check-lg"></i>
            Selesai Garis

        </button>

        <button
            type="button"
            class="btn btn-outline-danger"
            id="btnResetGaris">

            <i class="bi bi-arrow-counterclockwise"></i>
            Reset

        </button>

    </div>

</div>


{{-- Koordinat garis dikirim ke backend --}}
<input
    type="hidden"
    name="garis_koordinat"
    id="garisKoordinat">


{{-- ==========================
     Peta
========================== --}}
<div class="mb-3">

    <div
        id="map"
        style="height:300px; border-radius:10px;">
    </div>

</div>


{{-- ==========================
     Koordinat Representatif
========================== --}}
<div class="row">

    <div class="col-6">

        <label>Latitude</label>

        <input
            type="text"
            id="latitude"
            name="latitude"
            class="form-control"
            readonly>

        @error('latitude')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="col-6">

        <label>Longitude</label>

        <input
            type="text"
            id="longitude"
            name="longitude"
            class="form-control"
            readonly>

    </div>

</div>


<div class="mt-3">

    <label class="form-label">
        Alamat
    </label>

    <textarea
        id="alamat"
        name="alamat"
        class="form-control"
        rows="3"
        readonly
        placeholder="Alamat akan terisi otomatis setelah memilih lokasi"></textarea>

</div>

                <button type="submit"
                class="btn btn-success w-100 mt-4"
                id="btnSubmit">
                    <span id="submitText">
                        <i class="bi bi-send-fill me-1"></i>
                        Kirim Laporan
                    </span>
                
                    <span id="submitLoading" class="d-none">
                        <span class="spinner-border spinner-border-sm me-2"
                              role="status"
                              aria-hidden="true"></span>
                        Mengirim laporan...
                    </span>
                
                </button>
        </form>
    
    </div>

@endsection



@section('scripts')

<script>

document.addEventListener("DOMContentLoaded", function () {

// ==========================
// Inisialisasi Peta
// ==========================
    var map = L.map('map').setView([-7.817,110.920],13);
    
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{
        maxZoom:19,
        attribution:'© OpenStreetMap'
    }).addTo(map);
    
    let marker;
    let batasLayer;
    let garisLayer = null;
    let titikGaris = [];
    let garisSelesai = false;
    let modeLokasi = 'titik';
    
    const redIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        iconSize: [25,41],
        iconAnchor: [12,41],
        popupAnchor: [1,-34]
    });
    
// ==========================
// Tampilkan Batas Wonogiri
// ==========================
    fetch("{{ route('geojson.wonogiri') }}")
    .then(res => res.json())
    .then(data => {
    
        batasLayer = L.geoJSON(data,{
            style:{
                color:"#0d6efd",
                weight:2,
                fillColor:"#0d6efd",
                fillOpacity:0.15
            }
        }).addTo(map);
    
        map.fitBounds(batasLayer.getBounds());
    
    });
    
    setTimeout(function(){
        map.invalidateSize();
    },300);

// ==========================
// Ambil Alamat
// ==========================
    function getAlamat(lat,lng){
    
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
        .then(res=>res.json())
        .then(data=>{
    
            document.getElementById('alamat').value =
                data.display_name ?? "Alamat tidak ditemukan";
    
        })
        .catch(()=>{
            document.getElementById('alamat').value =
                "Gagal mengambil alamat";
        });
    
    }
    function cekWonogiri(lat, lng) {
    
        return fetch("{{ route('cek.wonogiri') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                latitude: lat,
                longitude: lng
            })
        })
        .then(res => res.json());
    
    }
    function kosongkanLokasi() {

    document.getElementById('latitude').value = '';
    document.getElementById('longitude').value = '';
    document.getElementById('alamat').value = '';
    document.getElementById('garisKoordinat').value = '';

}
function hapusMarker() {

    if (marker) {
        map.removeLayer(marker);
        marker = null;
    }

}
function hapusGaris() {

    if (garisLayer) {
        map.removeLayer(garisLayer);
        garisLayer = null;
    }

    titikGaris = [];
    garisSelesai = false;

    document.getElementById('garisKoordinat').value = '';
    document.getElementById('btnSelesaiGaris').disabled = true;

}
document.querySelectorAll('input[name="tipe_lokasi"]')
    .forEach(function(input) {

        input.addEventListener('change', function() {

            modeLokasi = this.value;

            kosongkanLokasi();

            if (modeLokasi === 'titik') {

                hapusGaris();

                document
                    .getElementById('containerLokasiSaya')
                    .classList.remove('d-none');

                document
                    .getElementById('kontrolGaris')
                    .classList.add('d-none');

                document.getElementById('petunjukLokasi').innerText =
                    'Pilih titik lokasi kerusakan pada peta.';

            } else {

                hapusMarker();

                document
                    .getElementById('containerLokasiSaya')
                    .classList.add('d-none');

                document
                    .getElementById('kontrolGaris')
                    .classList.remove('d-none');

                document.getElementById('petunjukLokasi').innerText =
                    'Ketuk beberapa titik pada peta untuk menggambar ruas kerusakan.';

            }

        });

    });
// ==========================
// Klik Peta
// ==========================
    map.on('click', function(e) {

    const lat = e.latlng.lat;
    const lng = e.latlng.lng;

    // ==========================
    // MODE TITIK
    // ==========================
    if (modeLokasi === 'titik') {

        cekWonogiri(lat, lng)
        .then(data => {

            hapusMarker();

            if (!data.inside) {

                kosongkanLokasi();

                marker = L.marker(
                    [lat, lng],
                    { icon: redIcon }
                )
                .addTo(map)
                .bindPopup(`
                    <b style="color:red;">
                        ⚠ Lokasi berada di luar Kabupaten Wonogiri
                    </b>
                    <br>
                    Silakan pilih lokasi di dalam wilayah Wonogiri.
                `)
                .openPopup();

                return;
            }

            document.getElementById('latitude').value =
                lat.toFixed(7);

            document.getElementById('longitude').value =
                lng.toFixed(7);

            marker = L.marker([lat, lng])
                .addTo(map);

            getAlamat(lat, lng);

        });

        return;
    }


    // ==========================
    // MODE GARIS
    // ==========================

    if (garisSelesai) {
        return;
    }

    cekWonogiri(lat, lng)
    .then(data => {

        if (!data.inside) {

            alert(
                'Titik garis berada di luar Kabupaten Wonogiri.'
            );

            return;
        }

        titikGaris.push([lat, lng]);

        if (garisLayer) {
            map.removeLayer(garisLayer);
        }

        garisLayer = L.polyline(
            titikGaris,
            {
                color: '#dc3545',
                weight: 5
            }
        ).addTo(map);

        // Format dikirim ke server:
        // [[lng,lat], [lng,lat], ...]
        const koordinatServer =
            titikGaris.map(function(titik) {

                return [
                    titik[1],
                    titik[0]
                ];

            });

        document.getElementById('garisKoordinat').value =
            JSON.stringify(koordinatServer);

        if (titikGaris.length >= 2) {

            document
                .getElementById('btnSelesaiGaris')
                .disabled = false;

        }

    });

});
document
    .getElementById('btnResetGaris')
    .addEventListener('click', function() {

        hapusGaris();
        kosongkanLokasi();

    });
    document
    .getElementById('btnSelesaiGaris')
    .addEventListener('click', function() {

        if (titikGaris.length < 2) {

            alert(
                'Garis harus memiliki minimal dua titik.'
            );

            return;
        }

        garisSelesai = true;

        const bounds = garisLayer.getBounds();

        const tengah = bounds.getCenter();

        document.getElementById('latitude').value =
            tengah.lat.toFixed(7);

        document.getElementById('longitude').value =
            tengah.lng.toFixed(7);

        getAlamat(
            tengah.lat,
            tengah.lng
        );

        document.getElementById('petunjukLokasi').innerText =
            'Garis kerusakan berhasil dibuat.';

        this.disabled = true;

    });
    
// ==========================
// Tombol Gunakan Lokasi Saat Ini
// ==========================
document.getElementById('btnLokasi').addEventListener('click', function(){
if (modeLokasi !== 'titik') {
    return;
}
    if (!navigator.geolocation) {

        alert('Browser tidak mendukung Geolocation.');
        return;

    }

    navigator.geolocation.getCurrentPosition(function(position){

        let lat = position.coords.latitude;
        let lng = position.coords.longitude;

        // Cek apakah lokasi berada di wilayah Wonogiri
        fetch("{{ route('cek.wonogiri') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                latitude: lat,
                longitude: lng
            })
        })
        .then(res => res.json())
        .then(data => {

            // Hapus marker sebelumnya
            if(marker){
                map.removeLayer(marker);
                marker = null;
            }

            // ==========================
            // JIKA DI LUAR WONOGIRI
            // ==========================
            if(!data.inside){

                map.setView([lat, lng], 12);

                marker = L.marker([lat, lng], {
                    icon: redIcon
                })
                .addTo(map)
                .bindPopup(`
                    <div style="text-align:center;">
                        <div style="
                            font-size:30px;
                            margin-bottom:8px;
                        ">
                            ⚠️
                        </div>

                        <b style="color:#dc3545;">
                            Anda berada di luar wilayah Wonogiri
                        </b>

                        <div style="
                            font-size:12px;
                            margin-top:6px;
                            color:#666;
                        ">
                            Silakan pilih lokasi kerusakan
                            secara manual pada peta.
                        </div>
                    </div>
                `)
                .openPopup();

                // Pastikan koordinat laporan dikosongkan
                document.getElementById('latitude').value = '';
                document.getElementById('longitude').value = '';
                document.getElementById('alamat').value = '';

                return;
            }

            // ==========================
            // JIKA DI DALAM WONOGIRI
            // ==========================

            document.getElementById('latitude').value =
                lat.toFixed(7);

            document.getElementById('longitude').value =
                lng.toFixed(7);

            marker = L.marker([lat, lng])
                .addTo(map);

            map.setView([lat, lng], 17);

            getAlamat(lat, lng);

        })
        .catch(() => {

            alert('Gagal memeriksa lokasi. Silakan coba lagi.');

        });

    }, function(){

        alert(
            'Lokasi tidak dapat diperoleh. ' +
            'Pastikan GPS/lokasi perangkat diaktifkan dan izin lokasi diberikan.'
        );

    });

});


// ==========================
// Upload & Preview Foto
// ==========================
    const inputFoto = document.getElementById('foto');
    const uploadCard = document.getElementById('uploadCard');
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('previewContainer');
    const gantiFoto = document.getElementById('gantiFoto');

    uploadCard.addEventListener('click', function () {
        inputFoto.click();
    });
    
    gantiFoto.addEventListener('click', function () {
        inputFoto.click();
    });

inputFoto.addEventListener('change', function () {

    if (this.files.length > 0) {

        const reader = new FileReader();

        reader.onload = function(e){

            preview.src = e.target.result;

            previewContainer.classList.remove('d-none');

            uploadCard.classList.add('d-none');

        }

        reader.readAsDataURL(this.files[0]);

    }

});
// ==========================
// Loading Saat Submit Laporan
// ==========================
const formLaporan = document.getElementById('formLaporan');
const btnSubmit = document.getElementById('btnSubmit');
const submitText = document.getElementById('submitText');
const submitLoading = document.getElementById('submitLoading');

formLaporan.addEventListener('submit', function () {

    submitText.classList.add('d-none');
    submitLoading.classList.remove('d-none');

    btnSubmit.disabled = true;

});
});



</script>



@endsection