# Sistem Manajemen Kos dan Indekos

> Project UCP — Pengembangan Desain Web
> Stack: **PHP murni + MySQL + TailwindCSS**

## 👥 Tim

| No | Nama | NIM | Role |
|----|------|-----|------|
| 1 | Rangga Alfarizzy | 20240140059 | Project Lead / Backend Core |
| 2 | Bima Eka Setiawan | 20240140089 | Database Engineer |
| 3 | Farhan Rasyid Mustaqim | 20240140102 | Frontend Lead / UI Designer |
| 4 | A.Muh. Fadil Asytar | 20240140133 | Room Catalog & Search |
| 5 | Drivandi Pratama | 20240140061 | Booking & Payment Module |
| 6 | Dzaki Ahmad Fauzi | 20240140082 | Owner Dashboard |
| 7 | Nur Sidik Zainu Ahmad | 20240140177 | Optional Features + QA/Docs |

## 🚀 Cara Menjalankan (XAMPP)

1. Pastikan **XAMPP** terinstall (Apache + MySQL aktif).
2. Copy folder project ini ke `C:\xampp\htdocs\pdw-ucp` (atau folder htdocs Anda).
3. Buka **phpMyAdmin** → http://localhost/phpmyadmin
4. Buat database baru: `kos_indekos` (utf8mb4_unicode_ci).
5. Import file `sql/schema.sql` lalu `sql/seed.sql`.
6. Edit `config/database.php` bila kredensial MySQL Anda berbeda dari default XAMPP.
7. Buka di browser: **http://localhost/pdw-ucp/public/**

### Akun Demo (setelah seed)
- **Pemilik kos**: `owner@kos.id` / `owner123`
- **Penghuni**: `penghuni@kos.id` / `pengguna123`

## 📋 Fitur

### Publik (calon penghuni)
- ✅ Room Catalog — daftar kamar dengan foto, tipe, ukuran, fasilitas, harga, status
- ✅ Detail kamar
- ✅ Filter & search berdasarkan tipe / harga / fasilitas
- ✅ Form Ajukan Sewa (Room Booking Request)
- ✅ Pengumuman publik

### Penghuni (setelah disetujui)
- ✅ Upload bukti pembayaran
- ✅ Billing Summary — rekap tagihan & status lunas/belum lunas
- ✅ Lihat pengumuman

### Pemilik Kos (Owner Dashboard)
- ✅ Dashboard statistik (kamar, hunian, pendapatan)
- ✅ CRUD kamar (foto, fasilitas, harga)
- ✅ Approve permohonan sewa
- ✅ Validasi bukti pembayaran
- ✅ Manajemen penghuni
- ✅ Pengumuman & notifikasi
- ✅ Laporan keuangan (chart sederhana)

## 🛠️ Stack

- **Backend**: PHP 8+ murni (no framework)
- **Database**: MySQL / MariaDB
- **Frontend**: TailwindCSS (via CDN untuk dev, build minified untuk produksi)
- **Chart**: Chart.js (CDN)
- **Icons**: Heroicons inline SVG

## 📁 Struktur

```
pdw-ucp/
├── config/
│   └── database.php       # Koneksi PDO
├── includes/
│   ├── auth.php           # Session, login, role guard
│   ├── helpers.php        # Utility: format, sanitize
│   ├── header.php         # Layout atas (navbar + tailwind)
│   └── footer.php         # Layout bawah
├── sql/
│   ├── schema.sql         # Struktur tabel
│   └── seed.sql           # Data demo
├── assets/
│   ├── css/style.css
│   ├── js/app.js
│   └── img/
├── uploads/
│   ├── kamar/             # Foto kamar
│   └── bukti/             # Bukti pembayaran
├── public/                # Entry point web
│   ├── index.php          # Katalog kamar (publik)
│   ├── detail.php
│   ├── booking.php
│   ├── login.php
│   ├── register.php
│   ├── logout.php
│   ├── pengumuman.php
│   ├── tagihan.php        # Billing summary (penghuni)
│   ├── upload-bukti.php
│   └── admin/             # Owner Dashboard
│       ├── index.php
│       ├── kamar.php
│       ├── kamar-form.php
│       ├── booking.php
│       ├── pembayaran.php
│       ├── penghuni.php
│       ├── pengumuman.php
│       └── laporan.php
└── docs/
    ├── tim-assignment.md
    └── erd.md
```

## 🔒 Keamanan

- Password di-hash dengan `password_hash()` (bcrypt)
- Semua query pakai PDO prepared statements
- Validasi input sisi server
- CSRF token pada form sensitif
- Session-based auth dengan role (`owner` / `penghuni`)

## 📜 Lisensi

Project akademik — Universitas Muhammadiyah Yogyakarta, 2026.
