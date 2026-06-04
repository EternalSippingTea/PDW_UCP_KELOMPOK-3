<?php
require_once __DIR__ . '/../includes/auth.php';
if (is_logged_in()) redirect('index.php');

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!csrf_check($_POST['_csrf'] ?? '')) { $err = 'Sesi tidak valid.'; }
  else try {
    $id = register_user(
      trim($_POST['nama'] ?? ''),
      trim($_POST['email'] ?? ''),
      $_POST['password'] ?? '',
      trim($_POST['telepon'] ?? ''),
      trim($_POST['alamat'] ?? '')
    );
    attempt_login($_POST['email'], $_POST['password']);
    set_flash('success', 'Pendaftaran berhasil!');
    redirect('index.php');
  } catch (Throwable $e) { $err = $e->getMessage(); }
}

$page_title = 'Daftar';
include __DIR__ . '/../includes/header.php';
?>

<div class="min-h-[70vh] grid place-items-center px-4 py-8">
  <div class="w-full max-w-md card p-8">
    <h1 class="text-2xl font-bold">Daftar Akun</h1>
    <p class="text-sm text-slate-500 mt-1">Buat akun untuk mengajukan sewa & upload bukti bayar.</p>

    <?php if ($err): ?>
      <div class="mt-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm"><?= e($err) ?></div>
    <?php endif; ?>

    <form method="post" class="mt-6 space-y-3">
      <?= csrf_input() ?>
      <div>
        <label class="text-xs text-slate-500">Nama lengkap</label>
        <input name="nama" required class="input mt-1" value="<?= e($_POST['nama'] ?? '') ?>">
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="text-xs text-slate-500">Email</label>
          <input type="email" name="email" required class="input mt-1" value="<?= e($_POST['email'] ?? '') ?>">
        </div>
        <div>
          <label class="text-xs text-slate-500">Telepon</label>
          <input name="telepon" class="input mt-1" value="<?= e($_POST['telepon'] ?? '') ?>">
        </div>
      </div>
      <div>
        <label class="text-xs text-slate-500">Password (min. 6 karakter)</label>
        <input type="password" name="password" required minlength="6" class="input mt-1">
      </div>
      <div>
        <label class="text-xs text-slate-500">Alamat (opsional)</label>
        <textarea name="alamat" rows="2" class="input mt-1"><?= e($_POST['alamat'] ?? '') ?></textarea>
      </div>
      <button class="btn btn-primary w-full">Daftar Sekarang</button>
    </form>

    <p class="text-sm text-slate-500 text-center mt-5">
      Sudah punya akun? <a href="login.php" class="text-brand-600 font-semibold hover:underline">Masuk</a>
    </p>
  </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
