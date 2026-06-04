<?php
/**
 * Pengumuman publik — Nur Sidik
 */
require_once __DIR__ . '/../includes/auth.php';

$rows = $pdo->query("
  SELECT p.*, u.nama AS author_nama
  FROM pengumuman p
  JOIN users u ON u.id = p.created_by
  ORDER BY p.created_at DESC
")->fetchAll();

$page_title = 'Pengumuman';
include __DIR__ . '/../includes/header.php';
?>

<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
  <h1 class="text-2xl font-bold">Pengumuman</h1>
  <p class="text-sm text-slate-500 mt-1">Informasi penting dari pemilik kos untuk seluruh penghuni.</p>

  <?php if (!$rows): ?>
    <div class="card p-8 mt-5 text-center text-slate-500">Belum ada pengumuman.</div>
  <?php else: ?>
  <div class="space-y-3 mt-5">
    <?php foreach ($rows as $r): ?>
      <article class="card p-5">
        <div class="flex items-start justify-between gap-3">
          <h3 class="text-lg font-bold"><?= e($r['judul']) ?></h3>
          <span class="badge badge-approved"><?= e($r['kategori']) ?></span>
        </div>
        <p class="mt-2 text-sm text-slate-700 leading-relaxed"><?= nl2br(e($r['isi'])) ?></p>
        <div class="text-xs text-slate-400 mt-3">Oleh <?= e($r['author_nama']) ?> · <?= rel_time($r['created_at']) ?></div>
      </article>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
