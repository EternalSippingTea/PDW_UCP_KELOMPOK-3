<?php
// Sidebar khusus admin dashboard.
$nav = [
  [BASE_URL . '/admin/',             'Dashboard',  'home'],
  [BASE_URL . '/admin/kamar.php',    'Kamar',      'door'],
  [BASE_URL . '/admin/booking.php',  'Permohonan', 'inbox'],
  [BASE_URL . '/admin/pembayaran.php','Pembayaran','wallet'],
  [BASE_URL . '/admin/penghuni.php', 'Penghuni',   'users'],
  [BASE_URL . '/admin/pengumuman.php','Pengumuman','bell'],
  [BASE_URL . '/admin/laporan.php',  'Laporan',    'chart'],
];
$icons = [
  'home'   => '<path d="M3 12l9-9 9 9M5 10v10h14V10"/>',
  'door'   => '<path d="M4 21V3h12v18M9 12h.01M20 21H2"/>',
  'inbox'  => '<path d="M22 12h-6l-2 3h-4l-2-3H2M5 21h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z"/>',
  'wallet' => '<path d="M3 7h18v12H3zM16 12h2"/>',
  'users'  => '<path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>',
  'bell'   => '<path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 1 1-6 0"/>',
  'chart'  => '<path d="M3 3v18h18M7 15l4-4 3 3 5-6"/>',
];
$cur = strtok($_SERVER['REQUEST_URI'], '?');
?>
<aside class="hidden md:flex w-64 flex-col bg-white border-r border-slate-200 sticky top-16 h-[calc(100vh-4rem)]">
  <div class="px-4 py-4 border-b border-slate-200">
    <div class="text-xs font-medium uppercase tracking-wider text-slate-400">Owner Panel</div>
    <div class="text-sm font-semibold mt-0.5"><?= e($me['nama'] ?? 'Pemilik') ?></div>
  </div>
  <nav class="p-2 space-y-0.5 overflow-y-auto flex-1">
    <?php foreach ($nav as [$path, $label, $ic]):
      $active = ($cur === $path) || (rtrim($cur,'/') === rtrim($path,'/'));
    ?>
      <a href="<?= $path ?>"
         class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm <?= $active?'bg-brand-50 text-brand-700 font-semibold':'text-slate-600 hover:bg-slate-50' ?>">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><?= $icons[$ic] ?? '' ?></svg>
        <?= $label ?>
      </a>
    <?php endforeach; ?>
  </nav>
  <div class="p-3 border-t border-slate-200">
    <a href="<?= BASE_URL ?>/" class="block text-xs text-slate-500 hover:text-slate-900">← Kembali ke katalog</a>
  </div>
</aside>
