<?php
/**
 * Koneksi database (PDO MySQL).
 * Ganti kredensial sesuai environment Anda.
 */

const DB_HOST = 'localhost';
const DB_NAME = 'kos_indekos';
const DB_USER = 'root';
const DB_PASS = '';        // default XAMPP: kosong
const DB_PORT = 3306;
const DB_CHARSET = 'utf8mb4';

const APP_NAME = 'Kos & Indekos';

// --- Auto-deteksi URL dasar (jalan di XAMPP & cPanel tanpa perlu diedit) ---
// Mendeteksi lokasi folder project dari URL yang diakses, lalu menurunkan
// URL untuk public/, assets/, dan uploads/. Tidak ada path yang di-hardcode.
$__script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$__pos    = strpos($__script, '/public/');
$__root   = $__pos !== false ? substr($__script, 0, $__pos) : rtrim(dirname($__script), '/');
define('ROOT_URL',   $__root);                // URL ke folder project (mis. /PDW-UCP atau '')
define('BASE_URL',   ROOT_URL . '/public');   // URL ke folder public (entry point)
define('ASSET_URL',  ROOT_URL . '/assets');   // URL ke assets (css/js)
define('UPLOAD_URL', ROOT_URL . '/uploads');  // URL ke uploads (foto kamar/bukti)

const UPLOAD_DIR = __DIR__ . '/../uploads';   // path filesystem untuk simpan file

try {
  $pdo = new PDO(
    "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
    DB_USER, DB_PASS,
    [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ]
  );
} catch (PDOException $e) {
  die('<div style="font-family:sans-serif;padding:2rem;color:#b91c1c">
    <h2>Database connection failed</h2>
    <p>' . htmlspecialchars($e->getMessage()) . '</p>
    <p>Pastikan MySQL aktif & database <code>' . DB_NAME . '</code> sudah dibuat (lihat README.md).</p>
    </div>');
}
