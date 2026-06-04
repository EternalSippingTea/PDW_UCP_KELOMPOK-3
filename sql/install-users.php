<?php
/**
 * Jalankan SEKALI setelah import schema.sql (jangan import seed.sql untuk users).
 * URL: http://localhost/pdw-ucp/sql/install-users.php
 *
 * Script ini membuat akun demo dengan bcrypt hash yang valid.
 * Hapus / amankan file ini setelah selesai.
 */
require __DIR__ . '/../config/database.php';

$users = [
  ['Pemilik Kos',  'owner@kos.id',    'owner123',    '0812-1000-0001', 'owner',    'Jl. Mawar No. 1'],
  ['Andi Saputra', 'penghuni@kos.id', 'pengguna123', '0812-2000-0002', 'penghuni', 'Bantul'],
  ['Budi Hartono', 'budi@kos.id',     'pengguna123', '0812-2000-0003', 'penghuni', 'Sleman'],
  ['Citra Dewi',   'citra@kos.id',    'pengguna123', '0812-2000-0004', 'penghuni', 'Yogyakarta'],
];

$stmt = $pdo->prepare("
  INSERT INTO users (nama, email, password_hash, telepon, role, alamat)
  VALUES (?,?,?,?,?,?)
  ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)
");

foreach ($users as $u) {
  $hash = password_hash($u[2], PASSWORD_BCRYPT);
  $stmt->execute([$u[0], $u[1], $hash, $u[3], $u[4], $u[5]]);
  echo "✓ {$u[1]} ({$u[4]})\n";
}

echo "\nSelesai. Hapus file install-users.php sekarang.\n";
