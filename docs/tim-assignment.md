# Pembagian Tugas Tim — Sistem Manajemen Kos & Indekos

Dipetakan ke bobot penilaian PRD:
- Logika Pemesanan & Verifikasi Pembayaran → **35%**
- Fungsionalitas Pemilik Kos (Dashboard) → **25%**
- Implementasi Antarmuka (Front-end) → **20%**
- Fitur Tambahan → **10%**
- Kualitas Source Code → **10%**

---

## 1. Rangga Alfarizzy (20240140059) — Project Lead / Backend Core

**Fokus**: Pondasi sistem, kualitas kode (10%)
- Setup repository Git, struktur folder, branching strategy
- File `config/database.php` (koneksi PDO)
- File `includes/auth.php` (login, register, session, role guard, CSRF)
- File `includes/helpers.php` (sanitize, format, redirect)
- Code review semua PR
- Deployment ke server (XAMPP demo / shared hosting)

## 2. Bima Eka Setiawan (20240140089) — Database Engineer

**Fokus**: Schema MySQL solid
- Desain ERD (`docs/erd.md`)
- `sql/schema.sql`: tabel users, kamar, foto_kamar, booking, pembayaran, tagihan, pengumuman
- `sql/seed.sql`: data demo realistis
- Index & relasi (FK, ON DELETE)
- Query optimization untuk dashboard

## 3. Farhan Rasyid Mustaqim (20240140102) — Frontend Lead / UI Designer

**Fokus**: Implementasi Antarmuka (20%)
- Setup TailwindCSS (CDN dev + plan build)
- Design system: warna, typography, button, badge, card
- `includes/header.php` + `footer.php` (navbar responsive, footer)
- Page transitions, loading state, empty state
- Mobile-first responsive untuk seluruh halaman publik

## 4. A.Muh. Fadil Asytar (20240140133) — Room Catalog & Search

**Fokus**: Room Catalog + Pencarian (Fitur Tambahan 10%)
- `public/index.php` — katalog kamar dengan grid responsive
- `public/detail.php` — detail kamar dengan gallery foto
- **Status Badge**: hijau (tersedia) / abu-abu (terisi)
- Filter & search: tipe, range harga, fasilitas
- Lazy loading foto

## 5. Drivandi Pratama (20240140061) — Booking & Payment 🔥

**Fokus**: Logika Pemesanan & Verifikasi (35% — BOBOT TERBESAR)
- `public/booking.php` — Form Ajukan Sewa
  - Tombol "Ajukan Sewa" kontras tinggi
  - Validasi: tanggal mulai, durasi, data diri
  - Anti-double booking (kamar terisi tidak bisa di-book)
- `public/upload-bukti.php` — Upload bukti transfer
  - Validasi MIME type, ukuran file
  - Simpan ke `uploads/bukti/`
- Logika status booking: pending → approved → ongoing → completed
- Penomoran invoice / kode booking unik

## 6. Dzaki Ahmad Fauzi (20240140082) — Owner Dashboard

**Fokus**: Fungsionalitas Pemilik Kos (25%)
- `public/admin/index.php` — Dashboard stats (kamar total, terisi, kosong, pendapatan)
- `public/admin/kamar.php` + `kamar-form.php` — CRUD kamar (foto, fasilitas)
- `public/admin/booking.php` — Daftar permohonan + approve/reject
- `public/admin/pembayaran.php` — Validasi bukti bayar (verified/rejected)
- `public/admin/penghuni.php` — Daftar penghuni aktif
- `public/tagihan.php` — Billing Summary (sisi penghuni)

## 7. Nur Sidik Zainu Ahmad (20240140177) — Optional Features + QA/Docs

**Fokus**: Fitur Tambahan (10%) + Kualitas Source Code (10% bareng Rangga)
- `public/admin/pengumuman.php` + `public/pengumuman.php` — sistem pengumuman
- `public/admin/laporan.php` — laporan keuangan + Chart.js
- Pencarian advanced (bareng Fadil)
- README.md, ERD diagram (PNG/Mermaid)
- Testing flow end-to-end, dokumentasi bug
- Quality checklist sebelum submit

---

## 🔁 Titik Sinkronisasi Wajib

| Pertemuan | Yang Hadir | Topik |
|---|---|---|
| Hari 1 | Semua | Kickoff, baca PRD, sepakati ERD draft |
| Hari 2 | Rangga, Bima, Farhan | Setup repo, schema final, design tokens |
| Hari 3 | Drivandi, Dzaki | Flow booking → approve → tagihan |
| Hari 4 | Fadil, Farhan | Komponen katalog & filter |
| Hari 5 | Semua | Integration test |
| Hari 6 | Nur Sidik + Rangga | QA, polish, dokumentasi |
| Hari 7 | Semua | Demo & submit |

## ✅ Definition of Done (per modul)

- Validasi input (client + server)
- Pesan error/sukses jelas
- Mobile responsive (cek di Chrome DevTools 375px)
- Tidak ada SQL injection (semua pakai prepared statement)
- Tidak ada XSS (semua output di-escape via `e()` helper)
- Sudah di-test minimal 1 happy path + 1 error path
