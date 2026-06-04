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
const APP_URL  = 'http://localhost/pdw-ucp/public';   // sesuaikan
const UPLOAD_DIR = __DIR__ . '/../uploads';
const UPLOAD_URL = '/pdw-ucp/uploads';                // path public ke uploads

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
