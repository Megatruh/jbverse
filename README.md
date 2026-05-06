<p align="center">
	<img src="docs/banner.png" alt="JBVerse Banner" width="100%" />
</p>

<h1 align="center">JBVerse (Janur Belakang Universe)</h1>

<p align="center">
	<a href="https://laravel.com"><img alt="Laravel" src="https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white"></a>
	<img alt="PHP" src="https://img.shields.io/badge/PHP-%3E%3D8.1-777BB4?logo=php&logoColor=white">
	<img alt="MySQL" src="https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql&logoColor=white">
	<img alt="License" src="https://img.shields.io/badge/License-MIT-green.svg">
</p>

<p align="center">
	Sistem informasi <b>katalog digital</b> berbasis Laravel untuk mendata, mempromosikan, dan menghubungkan <b>UMKM/Jajanan</b> di sekitar area kampus <b>Universitas Siliwangi</b> dengan masyarakat luas.
</p>

---

## Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Tangkapan Layar](#tangkapan-layar)
- [Stack Teknologi](#stack-teknologi)
- [Fitur Utama](#fitur-utama)
	- [👀 Pengunjung (Guest/User)](#-pengunjung-guestuser)
	- [🏪 Pengusaha (Mitra UMKM)](#-pengusaha-mitra-umkm)
	- [🛡️ Admin](#️-admin)
- [UI & Ikonografi (blade-heroicons)](#ui--ikonografi-blade-heroicons)
- [Prasyarat Sistem](#prasyarat-sistem)
- [Instalasi Lokal](#instalasi-lokal)
- [Default Credentials (Seeder)](#default-credentials-seeder)
- [Lisensi](#lisensi)

---

## Tentang Proyek

**JBVerse (Janur Belakang Universe)** adalah aplikasi web berbasis **Laravel 12** yang berfungsi sebagai **katalog digital UMKM/jajanan** di sekitar Universitas Siliwangi.

Masalah yang ingin diselesaikan:

- Banyak UMKM sekitar kampus belum memiliki etalase digital yang rapi dan mudah ditemukan.
- Pengunjung membutuhkan pencarian cepat, filter yang relevan, dan informasi lokasi yang akurat.
- Admin membutuhkan mekanisme moderasi (verifikasi pengusaha, penanganan laporan) untuk menjaga kualitas katalog.

Dengan JBVerse, pengusaha dapat mengelola profil dan menu secara mandiri, pengunjung dapat menemukan jajanan dengan cepat, dan admin dapat memverifikasi serta menindaklanjuti laporan.

---

## Tangkapan Layar

> Ganti placeholder berikut dengan gambar asli.

| Dasbor Admin | Katalog Menu | Peta Lokasi |
|---|---|---|
| ![Dasbor Admin](docs/screenshots/admin-dashboard.png) | ![Katalog Menu](docs/screenshots/katalog-menu.png) | ![Peta Lokasi](docs/screenshots/peta-lokasi.png) |

---

## Stack Teknologi

- **Backend**: Laravel 12
- **Database**: MySQL
- **Frontend**: Blade Templating, Tailwind CSS, Alpine.js
- **UI Components / Icons**: blade-heroicons (komponen ikon Blade yang ekstensif)

---

## Fitur Utama

### 👀 Pengunjung (Guest/User)

- 🔎 **Smart Search real-time (AJAX)** + Autocomplete
- 🧰 **Filter pencarian** untuk memudahkan eksplorasi
- 🏬 Melihat **detail UMKM** (deskripsi, menu, status operasional)
- 🗺️ **Rute langsung ke Google Maps** (berdasarkan koordinat UMKM)
- 📍 Integrasi **Geolocation** (membantu pengalaman peta/rute)
- 💸 Informasi menu dengan **varian harga** (rasa/ukuran) bila tersedia

Khusus user yang login:

- ⭐ Memberikan **rating/ulasan**
- ❤️ Menambahkan **favorit**
- 🚩 **Melaporkan UMKM** bermasalah

### 🏪 Pengusaha (Mitra UMKM)

- 📝 **Pendaftaran mitra** dengan verifikasi wajib oleh Admin (ACC)
- 🧑‍💼 **Dasbor pengusaha** untuk kelola profil toko (kontak, deskripsi, banner)
- 🍔 CRUD menu: **tambah / edit / hapus** menu
- 🧩 Varian menu **dinamis** (mis. rasa/ukuran) dengan **harga berbeda**
- 💬 **Membalas ulasan pelanggan**
- 🔁 **Toggle status toko buka/tutup** (untuk menandai ketersediaan operasional)
- 📌 Penentuan **koordinat toko (Latitude/Longitude)** otomatis menggunakan **HTML5 Geolocation API**

### 🛡️ Admin

- ✅ **ACC** pendaftaran pengusaha baru (verifikasi)
- 📊 Dasbor statistik (mis. total UMKM, laporan masuk)
- 🧾 Meninjau **laporan pengunjung**
- ⛔ Menindaklanjuti UMKM bermasalah (mis. **suspend** akun/toko)

---

## UI & Ikonografi (blade-heroicons)

JBVerse memanfaatkan **blade-heroicons** untuk ikon yang konsisten, ringan, dan mudah dipakai langsung di Blade.

Contoh penggunaan ikon di Blade (dengan Tailwind CSS):

```html
<x-heroicon-o-academic-cap class="w-6 h-6 text-blue-500" />
<x-heroicon-s-heart class="w-6 h-6 text-red-500" />
```

Tips:

- Gunakan prefix `o` untuk **outline** dan `s` untuk **solid**.
- Styling mengikuti Tailwind (ukuran `w/h`, warna `text-*`, dll).

---

## Prasyarat Sistem

Pastikan perangkat kamu sudah memiliki:

- **PHP >= 8.1**
- **Composer**
- **Node.js** + npm
- **MySQL**

---

## Instalasi Lokal

> Panduan berikut untuk menjalankan JBVerse secara lokal.

### 1) Clone repository

```sh
git clone <URL_REPOSITORY_GITHUB_KAMU>
cd jbverse
```

### 2) Install dependency backend (PHP)

```sh
composer install
```

### 3) Install dependency frontend & build asset

```sh
npm install
npm run build
```

> Opsional saat development: jalankan watcher

```sh
npm run dev
```

### 4) Setup environment (.env)

```sh
cp .env.example .env
```

Sesuaikan koneksi database di `.env`:

```php
APP_NAME="JBVerse"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jbverse
DB_USERNAME=root
DB_PASSWORD=
```

### 5) Generate app key

```sh
php artisan key:generate
```

### 6) Storage link (untuk banner/logo/menu images)

```sh
php artisan storage:link
```

### 7) Migrasi + seeding

```sh
php artisan migrate:fresh --seed
```

### 8) Jalankan server

```sh
php artisan serve
```

Buka aplikasi:

- http://localhost:8000

---

## Default Credentials (Seeder)

Berikut akun dummy yang dibuat oleh seeder (lihat `database/seeders/UserSeeder.php`):

| Role | Email | Password |
|---|---|---|
| Admin | `admin@jbverse.test` | `password123` |
| Pengusaha | `budi@jbverse.test` | `password123` |
| User | `user@jbverse.com` | `password123` |

Catatan:

- Seeder juga membuat **user/pengusaha random** tambahan via factory.
- Jika kamu menjalankan `php artisan migrate:fresh --seed` berkali-kali, data dummy akan di-reset.

---
