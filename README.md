# Lapor Jalan Wonogiri

**Lapor Jalan Wonogiri** merupakan aplikasi Sistem Informasi Geografis berbasis web dan *Progressive Web App* (PWA) yang dikembangkan untuk mendukung proses pelaporan, pemetaan, dan analisis prioritas penanganan kerusakan jalan di Kabupaten Wonogiri.

Aplikasi memungkinkan masyarakat untuk menyampaikan laporan kerusakan jalan berbasis lokasi, melihat persebaran laporan melalui peta, serta memantau perkembangan penanganan laporan. Administrator dapat mengelola laporan yang masuk dan melakukan analisis prioritas penanganan kerusakan jalan berdasarkan beberapa parameter spasial.

Aplikasi ini dikembangkan sebagai bagian dari Tugas Akhir Program Sarjana Terapan Sistem Informasi Geografis, Sekolah Vokasi, Universitas Gadjah Mada.

---

## Fitur Utama

### Masyarakat

- Registrasi dan login pengguna.
- Pengajuan laporan kerusakan jalan.
- Penentuan lokasi kerusakan berdasarkan koordinat.
- Unggah foto kerusakan jalan.
- Melihat daftar laporan.
- Melihat detail dan status perkembangan laporan.
- Melihat persebaran laporan melalui peta.
- Mengelola profil pengguna.
- Reset kata sandi melalui email.
- Akses aplikasi melalui perangkat desktop maupun mobile.

### Administrator

- Login sebagai administrator.
- Dashboard pengelolaan laporan.
- Melihat seluruh laporan masyarakat.
- Melihat detail laporan dan lokasi kerusakan.
- Mengubah status laporan menjadi:
  - Diproses
  - Diteruskan
  - Selesai
  - Ditolak
- Memberikan keterangan perkembangan laporan.
- Menghapus laporan apabila diperlukan.
- Melakukan analisis prioritas penanganan kerusakan jalan.
- Menampilkan hasil analisis dalam bentuk peta prioritas.


---

## Teknologi

Aplikasi dikembangkan menggunakan:

- Laravel
- PHP 8.2+
- PostgreSQL
- PostGIS
- Blade Template
- HTML
- CSS
- JavaScript
- Bootstrap
- Leaflet.js
- OpenStreetMap
- Progressive Web App (PWA)

---

## Struktur Proyek

```text
LAPOR-JALAN/
│
├── app/                                  # Logika utama aplikasi
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                     # Controller autentikasi Laravel
│   │   │   ├── AdminController.php       # Pengelolaan halaman dan fitur admin
│   │   │   ├── AnalisisPrioritasController.php
│   │   │   │                             # Proses analisis prioritas
│   │   │   ├── AuthController.php        # Proses autentikasi pengguna
│   │   │   ├── Controller.php            # Base controller Laravel
│   │   │   ├── HomeController.php        # Pengelolaan halaman utama
│   │   │   └── LaporanController.php     # Pengelolaan laporan kerusakan jalan
│   │   │
│   │   └── Middleware/                    # Autentikasi dan pembatasan hak akses
│   │
│   ├── Models/                            # Model dan relasi database
│   │   ├── User.php                       # Data pengguna
│   │   ├── Laporan.php                    # Data laporan kerusakan jalan
│   │   └── AnalisisPrioritas.php          # Data hasil analisis prioritas
│   │
│   ├── Notifications/                     # Notifikasi aplikasi
│   │                                      # termasuk reset password
│   │
│   └── Providers/                         # Service provider Laravel
│
├── bootstrap/                             # Bootstrap aplikasi Laravel
│
├── config/                                # Konfigurasi aplikasi
│
├── database/
│   ├── migrations/                        # Struktur tabel database
│   └── seeders/                           # Data awal database
│
├── public/                                # File yang dapat diakses publik
│   ├── images/                            # Logo dan gambar aplikasi
│   ├── storage/                           # File/foto hasil upload
│   └── index.php                          # Entry point aplikasi
│
├── resources/
│   ├── css/                               # Stylesheet aplikasi
│   ├── js/                                # JavaScript aplikasi
│   │
│   └── views/                             # Blade Template
│       ├── admin/                         # Halaman administrator
│       ├── auth/                          # Login, register, reset password
│       ├── components/                    # Komponen antarmuka
│       ├── laporan/                       # Halaman pengelolaan laporan
│       ├── layouts/                       # Layout utama aplikasi
│       └── user/                          # Halaman pengguna/masyarakat
│
├── routes/
│   ├── console.php                        # Route perintah console
│   └── web.php                            # Route aplikasi web
│
├── storage/                               # File aplikasi, cache, dan log
│
├── tests/                                 # Pengujian aplikasi
│
├── vendor/                                # Dependency Composer
│
├── .env                                   # Konfigurasi environment
├── .env.example                           # Template environment
├── artisan                                # Laravel CLI
├── composer.json                          # Dependency PHP
├── package.json                           # Dependency front-end
└── README.md                              # Dokumentasi proyek
```

---

## Basis Data

Aplikasi menggunakan **PostgreSQL** dengan ekstensi **PostGIS** untuk mendukung penyimpanan dan pengolahan data spasial.

Data utama yang digunakan meliputi:

- Data pengguna
- Data laporan kerusakan jalan
- Data hasil analisis prioritas
- Jaringan jalan
- Fasilitas umum
- Kepadatan penduduk
- Data administrasi wilayah

Pastikan ekstensi PostGIS telah diaktifkan pada database:

```sql
CREATE EXTENSION IF NOT EXISTS postgis;
```

---
## Cara Menjalankan Aplikasi

### 1. Clone Repository

```bash
git clone <URL_REPOSITORY>
cd lapor-jalan
```

### 2. Install Dependency

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`, kemudian sesuaikan konfigurasi database dan environment aplikasi.

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Siapkan Database

Pastikan PostgreSQL dan PostGIS telah tersedia, kemudian jalankan migration:

```bash
php artisan migrate
```

### 5. Membuat Symbolic Link Storage

```bash
php artisan storage:link
```

### 6. Menjalankan Aplikasi

```bash
npm run dev
php artisan serve
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

## Alur Penggunaan

Secara umum, alur penggunaan aplikasi adalah:

```text
Masyarakat
    ↓
Registrasi / Login
    ↓
Membuat Laporan Kerusakan Jalan
    ↓
Mengisi Informasi + Foto + Lokasi
    ↓
Laporan Terkirim
    ↓
Administrator Memeriksa Laporan
    ↓
Status Diubah Menjadi "Diproses"
    ↓
Analisis Prioritas
    ↓
P1 Fasilitas Umum
P2 Jenis Jalan
P3 Kepadatan Penduduk
    ↓
Perhitungan Skor Prioritas
    ↓
Rendah / Sedang / Tinggi
    ↓
Peta Prioritas Penanganan
    ↓
Administrator Memperbarui Perkembangan
    ↓
Laporan Selesai
```

---

## Hak Akses

Aplikasi memiliki dua jenis pengguna:

### Masyarakat

Masyarakat memiliki akses untuk membuat laporan, melihat laporan, melihat peta kerusakan jalan, memantau perkembangan laporan, dan mengelola profil.

### Administrator

Administrator memiliki akses untuk mengelola seluruh laporan, memperbarui status dan keterangan laporan, serta menjalankan dan melihat hasil analisis prioritas penanganan kerusakan jalan.

Pembatasan akses dilakukan menggunakan sistem autentikasi dan middleware Laravel.

---

## Progressive Web App

Lapor Jalan Wonogiri dikembangkan sebagai **Progressive Web App (PWA)** sehingga dapat digunakan melalui browser pada berbagai perangkat dan dapat dipasang pada perangkat pengguna seperti aplikasi.


---

## Pengembang

**Elvina Nur Riza Ardhana**  
Program Studi Sarjana Terapan Sistem Informasi Geografis  
Sekolah Vokasi  
Universitas Gadjah Mada
2026

---

## Lisensi

Proyek **Lapor Jalan Wonogiri** dikembangkan untuk keperluan Tugas Akhir pada Program Studi Sarjana Terapan Sistem Informasi Geografis, Sekolah Vokasi, Universitas Gadjah Mada.

Penggunaan, pengembangan, atau distribusi lebih lanjut dapat disesuaikan dengan ketentuan yang berlaku.