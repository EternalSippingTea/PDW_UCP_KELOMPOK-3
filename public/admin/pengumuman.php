<?php
/**
 * Pengumuman CRUD — Nur Sidik
 */
require_once __DIR__ . '/../../includes/auth.php';
require_owner();
$me = current_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (csrf_check($_POST['_csrf'] ?? '')) {
    $action = $_POST['action'] ?? 'create';
    if ($action === 'delete') {
      $pdo->prepare("DELETE FROM pengumuman WHERE id=?")->execute([(int)$_POST['id']]);
      set_flash('success','Pengumuman dihapus.');
    } else {
      $judul = trim($_POST['judul']); $isi = trim($_POST['isi']); $kat = $_POST['kategori'] ?? 'umum';
      if ($judul && $isi) {
        if ($action === 'update') {
          $pdo->prepare("UPDATE pengumuman SET judul=?, isi=?, kategori=? WHERE id=?")
              ->execute([$judul,$isi,$kat,(int)$_POST['id']]);
          set_flash('success','Pengumuman diperbarui.');
        } else {
          $pdo->prepare("INSERT INTO pengumuman (judul, isi, kategori, created_by) VALUES (?,?,?,?)")
              ->execute([$judul,$isi,$kat,$me['id']]);
          set_flash('success','Pengumuman dipublikasikan.');
        }
      }
    }
  }
  redirect('pengumuman.php');
}

$edit = null;
if (!empty($_GET['edit'])) {
  $stmt = $pdo->prepare("SELECT * FROM pengumuman WHERE id=?");
  $stmt->execute([(int)$_GET['edit']]);
  $edit = $stmt->fetch();
}

$rows = $pdo->query("
  SELECT p.*, u.nama AS author_nama FROM pengumuman p
  JOIN users u ON u.id = p.created_by ORDER BY p.created_at DESC
")->fetchAll();

$page_title = 'Pengumuman';
include __DIR__ . '/../../includes/header.php';
?>

<div class="flex">
<?php include __DIR__ . '/../../includes/admin-sidebar.php'; ?>

<div class="flex-1 p-4 md:p-8 max-w-5xl">
  <h1 class="text-2xl font-bold">Pengumuman</h1>
  <p class="text-sm text-slate-500 mt-1">Sebarkan informasi penting ke seluruh penghuni.</p>

  <form method="post" class="card p-5 mt-5 space-y-3">
    <?= csrf_input() ?>
    <input type="hidden" name="action" value="<?= $edit?'update':'create' ?>">
    <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit['id'] ?>"><?php endif; ?>

    <div class="grid sm:grid-cols-3 gap-3">
      <div class="sm:col-span-2"><label class="text-xs text-slate-500">Judul</label>
        <input name="judul" required class="input mt-1" value="<?= e($edit['judul'] ?? '') ?>"></div>
      <div><label class="text-xs text-slate-500">Kategori</label>
        <select name="kategori" class="input mt-1">
          <?php foreach (['umum','kebersihan','listrik','keamanan','keuangan'] as $k): ?>
            <option <?= ($edit['kategori'] ?? 'umum')===$k?'selected':'' ?>><?= $k ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div><label class="text-xs text-slate-500">Isi</label>
      <textarea name="isi" rows="4" required class="input mt-1"><?= e($edit['isi'] ?? '') ?></textarea>
    </div>
    <div class="flex justify-end gap-2">
      <?php if ($edit): ?><a href="pengumuman.php" class="btn btn-secondary">Batal</a><?php endif; ?>
      <button class="btn btn-primary"><?= $edit?'Update':'Publikasikan' ?></button>
    </div>
  </form>

  <div class="space-y-3 mt-6">
    <?php foreach ($rows as $r): ?>
      <article class="card p-5">
        <div class="flex items-start justify-between gap-3">
          <div>
            <h3 class="font-bold"><?= e($r['judul']) ?></h3>
            <div class="text-xs text-slate-400 mt-0.5">Oleh <?= e($r['author_nama']) ?> · <?= rel_time($r['created_at']) ?> · <span class="badge badge-approved"><?= e($r['kategori']) ?></span></div>
          </div>
          <div class="flex gap-1">
            <a href="?edit=<?= $r['id'] ?>" class="btn btn-secondary text-xs px-3 py-1.5">Edit</a>
            <form method="post" class="inline" data-confirm="Hapus pengumuman?">
              <?= csrf_input() ?>
              <input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $r['id'] ?>">
              <button class="btn btn-danger text-xs px-3 py-1.5">Hapus</button>
            </form>
          </div>
        </div>
        <p class="mt-2 text-sm text-slate-700"><?= nl2br(e($r['isi'])) ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</div>
</div>

<script src="<?= ASSET_URL ?>/js/app.js"></script>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
