-- ===============================================================
-- Sistem Manajemen Kos & Indekos — Schema
-- DB: kos_indekos (utf8mb4_unicode_ci)
-- ===============================================================

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS pembayaran;
DROP TABLE IF EXISTS tagihan;
DROP TABLE IF EXISTS booking;
DROP TABLE IF EXISTS foto_kamar;
DROP TABLE IF EXISTS pengumuman;
DROP TABLE IF EXISTS kamar;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- ---------- USERS ----------
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  telepon VARCHAR(20),
  role ENUM('owner','penghuni') NOT NULL DEFAULT 'penghuni',
  alamat TEXT,
  foto VARCHAR(255),
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- KAMAR ----------
CREATE TABLE kamar (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode VARCHAR(20) NOT NULL UNIQUE,
  tipe VARCHAR(50) NOT NULL,        -- Standar, Deluxe, VIP
  ukuran_m2 DECIMAL(5,2) NOT NULL,
  fasilitas TEXT,                   -- "AC, WiFi, Kamar mandi dalam"
  harga_bulanan DECIMAL(12,2) NOT NULL,
  status ENUM('tersedia','terisi') NOT NULL DEFAULT 'tersedia',
  foto_utama VARCHAR(255),
  deskripsi TEXT,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_status (status),
  INDEX idx_tipe (tipe)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- FOTO KAMAR (gallery) ----------
CREATE TABLE foto_kamar (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kamar_id INT NOT NULL,
  path VARCHAR(255) NOT NULL,
  CONSTRAINT fk_foto_kamar FOREIGN KEY (kamar_id) REFERENCES kamar(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- BOOKING ----------
CREATE TABLE booking (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode_booking VARCHAR(30) NOT NULL UNIQUE,
  user_id INT NOT NULL,
  kamar_id INT NOT NULL,
  nama_lengkap VARCHAR(100) NOT NULL,
  telepon VARCHAR(20) NOT NULL,
  email VARCHAR(150) NOT NULL,
  tanggal_mulai DATE NOT NULL,
  durasi_bulan INT NOT NULL DEFAULT 1,
  catatan TEXT,
  status ENUM('pending','approved','rejected','ongoing','completed','cancelled') NOT NULL DEFAULT 'pending',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  approved_at DATETIME NULL,
  CONSTRAINT fk_booking_user  FOREIGN KEY (user_id)  REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_booking_kamar FOREIGN KEY (kamar_id) REFERENCES kamar(id) ON DELETE CASCADE,
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- TAGIHAN bulanan ----------
CREATE TABLE tagihan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  booking_id INT NULL,
  user_id INT NOT NULL,
  kamar_id INT NOT NULL,
  periode VARCHAR(7) NOT NULL,     -- YYYY-MM
  nominal DECIMAL(12,2) NOT NULL,
  due_date DATE NOT NULL,
  status ENUM('belum','lunas') NOT NULL DEFAULT 'belum',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_tagihan_booking FOREIGN KEY (booking_id) REFERENCES booking(id) ON DELETE SET NULL,
  CONSTRAINT fk_tagihan_user    FOREIGN KEY (user_id)    REFERENCES users(id)   ON DELETE CASCADE,
  CONSTRAINT fk_tagihan_kamar   FOREIGN KEY (kamar_id)   REFERENCES kamar(id)   ON DELETE CASCADE,
  UNIQUE KEY uk_tagihan_periode (user_id, kamar_id, periode),
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- PEMBAYARAN ----------
CREATE TABLE pembayaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  tagihan_id INT NULL,
  booking_id INT NULL,
  nominal DECIMAL(12,2) NOT NULL,
  metode VARCHAR(30) NOT NULL DEFAULT 'transfer',
  bukti_path VARCHAR(255),
  status ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  catatan TEXT,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  verified_at DATETIME NULL,
  verified_by INT NULL,
  CONSTRAINT fk_pembayaran_user    FOREIGN KEY (user_id)    REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_pembayaran_tagihan FOREIGN KEY (tagihan_id) REFERENCES tagihan(id) ON DELETE SET NULL,
  CONSTRAINT fk_pembayaran_booking FOREIGN KEY (booking_id) REFERENCES booking(id) ON DELETE SET NULL,
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------- PENGUMUMAN ----------
CREATE TABLE pengumuman (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(200) NOT NULL,
  isi TEXT NOT NULL,
  kategori VARCHAR(50) DEFAULT 'umum',  -- kebersihan, listrik, umum, dll
  created_by INT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_pengumuman_user FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
