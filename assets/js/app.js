// Mini JS helpers (mobile menu sudah inline di header)

// Confirm sebelum form delete
document.addEventListener('submit', (e) => {
  const f = e.target;
  if (f.matches('form[data-confirm]')) {
    if (!confirm(f.dataset.confirm || 'Yakin?')) e.preventDefault();
  }
});

// Preview gambar sebelum upload
document.addEventListener('change', (e) => {
  const input = e.target.closest('input[type=file][data-preview]');
  if (!input?.files?.[0]) return;
  const target = document.querySelector(input.dataset.preview);
  if (!target) return;
  const r = new FileReader();
  r.onload = () => { target.src = r.result; target.classList.remove('hidden'); };
  r.readAsDataURL(input.files[0]);
});

// Auto-hide flash setelah 5s
setTimeout(() => document.querySelectorAll('main .border.rounded-xl').forEach(n => {
  n.style.transition='opacity .3s'; n.style.opacity='0';
  setTimeout(()=>n.remove(),300);
}), 5000);
