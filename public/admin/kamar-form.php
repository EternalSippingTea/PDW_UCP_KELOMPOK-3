<?php
/**
 * Form tambah/edit kamar — Dzaki
 */
require_once __DIR__ . '/../../includes/auth.php';
require_owner();

$id = (int)($_GET['id'] ?? 0);
$kamar = ['id'=>0,'kode'=>'','tipe'=>'Standar','ukuran_m2'=>9,'fasilitas'=>'','harga_bulanan'=>0,'status'=>'tersedia','foto_utama'=>'','deskripsi'=>''];

if ($id) {
  $stmt = $pdo->prepare("SELECT * FROM kamar WHERE id = ?");
  $stmt->execute([$id]);
  $kamar = $stmt->fetch();
  if (!$kamar) { http_response_code(404); die('Kamar tidak ditemukan'); }
}

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!csrf_check($_POST['_csrf'] ?? '')) { $err = 'CSRF gagal.'; }
  else try {
    $data = [
      'kode'         => trim($_POST['kode']),
      'tipe'         => trim($_POST['tipe']),
      'ukuran_m2'    => (float)$_POST['ukuran_m2'],
      'fasilitas'    => trim($_POST['fasilitas']),
      'harga_bulanan'=> (float)$_POST['harga_bulanan'],
      'status'       => $_POST['status'],
      'deskripsi'    => trim($_POST['deskripsi']),
    ];
    if (!$data['kode'] || !$data['tipe']) throw new RuntimeException('Kode dan tipe wajib diisi.');

    // Optional new foto
    try {
      $newPath = handle_upload('foto', 'kamar', 3_000_000);
      if ($newPath) $data['foto_utama'] = $newPath;
      elseif (isset($_POST['foto_url']) && $_POST['foto_url']) $data['foto_utama'] = $_POST['foto_url'];
      else $data['foto_utama'] = $kamar['foto_utama'];
    } catch (Throwable $e) { throw new RuntimeException('Upload foto: ' . $e->getMessage()); }

    if ($id) {
      $stmt = $pdo->prepare("UPDATE kamar SET kode=:kode, tipe=:tipe, ukuran_m2=:ukuran_m2, fasilitas=:fasilitas, harga_bulanan=:harga_bulanan, status=:status, deskripsi=:deskripsi, foto_utama=:foto_utama WHERE id=$id");
    } else {
      $stmt = $pdo->prepare("INSERT INTO kamar (kode, tipe, ukuran_m2, fasilitas, harga_bulanan, status, deskripsi, foto_utama) VALUES (:kode,:tipe,:ukuran_m2,:fasilitas,:harga_bulanan,:status,:deskripsi,:foto_utama)");
    }
    $stmt->execute($data);
    set_flash('success', $id ? 'Kamar diperbarui.' : 'Kamar ditambahkan.');
    redirect('kamar.php');
  } catch (Throwable $e) { $err = $e->getMessage(); }
}

$page_title = $id ? 'Edit Kamar' : 'Tambah Kamar';
include __DIR__ . '/../../includes/header.php';
?>

<div class="flex">
<?php include __DIR__ . '/../../includes/admin-sidebar.php'; ?>

<div class="flex-1 p-4 md:p-8 max-w-3xl">
  <a href="kamar.php" class="text-sm text-slate-500 hover:text-slate-900">← Kembali</a>
  <h1 class="text-2xl font-bold mt-2"><?= $id ? 'Edit Kamar' : 'Tambah Kamar' ?></h1>

  <?php if ($err): ?>
    <div class="mt-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm"><?= e($err) ?></div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" class="card p-6 mt-4 grid grid-cols-2 gap-3">
    <?= csrf_input() ?>
    <div><label class="text-xs text-slate-500">Kode</label><input name="kode" required class="input mt-1" value="<?= e($kamar['kode']) ?>" placeholder="K-101"></div>
    <div><label class="text-xs text-slate-500">Tipe</label>
      <select name="tipe" class="input mt-1">
        <?php foreach (['Standar','Deluxe','VIP'] as $t): ?>
          <option <?= $kamar['tipe']===$t?'selected':'' ?>><?= $t ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div><label class="text-xs text-slate-500">Ukuran (m²)</label><input type="number" step="0.1" name="ukuran_m2" required class="input mt-1" value="<?= e($kamar['ukuran_m2']) ?>"></div>
    <div><label class="text-xs text-slate-500">Harga / bulan (Rp)</label><input type="number" name="harga_bulanan" required class="input mt-1" value="<?= e($kamar['harga_bulanan']) ?>"></div>
    <div class="col-span-2"><label class="text-xs text-slate-500">Fasilitas (pisahkan dengan koma)</label><input name="fasilitas" class="input mt-1" value="<?= e($kamar['fasilitas']) ?>" placeholder="AC, WiFi, Kasur, Lemari"></div>
    <div><label class="text-xs text-slate-500">Status</label>
      <select name="status" class="input mt-1">
        <option value="tersedia" <?= $kamar['status']==='tersedia'?'selected':'' ?>>Tersedia</option>
        <option value="terisi"   <?= $kamar['status']==='terisi'?'selected':''   ?>>Terisi</option>
      </select>
    </div>
    <div><label class="text-xs text-slate-500">URL foto (opsional)</label><input name="foto_url" class="input mt-1" value="<?= e($kamar['foto_utama']) ?>" placeholder="https://…"></div>
    <div class="col-span-2"><label class="text-xs text-slate-500">Atau upload foto baru</label>
      <input type="file" name="foto" accept="image/*" data-preview="#preview" class="input mt-1">
      <img id="preview" src="<?= e($kamar['foto_utama']) ?>" class="<?= $kamar['foto_utama']?'':'hidden' ?> mt-3 max-h-48 rounded-lg">
    </div>
    <div class="col-span-2"><label class="text-xs text-slate-500">Deskripsi</label><textarea name="deskripsi" rows="3" class="input mt-1"><?= e($kamar['deskripsi']) ?></textarea></div>

    <div class="col-span-2 flex justify-end gap-2 mt-2">
      <a href="kamar.php" class="btn btn-secondary">Batal</a>
      <button class="btn btn-primary">Simpan</button>
    </div>
  </form>
</div>
</div>

<script src="<?= ASSET_URL ?>/js/app.js"></script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
