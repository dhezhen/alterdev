// Skrip panel admin (tanpa skrip inline agar sesuai Content Security Policy)
document.addEventListener('DOMContentLoaded', function () {
  var sidebar = document.getElementById('sidebar');
  var toggle = document.querySelector('[data-sidebar-toggle]');
  var menuGroups = document.querySelectorAll('[data-menu-group]');
  var menuBreakpoint = window.matchMedia('(max-width: 900px)');

  function syncMenuGroups() {
    menuGroups.forEach(function (group) {
      group.open = !menuBreakpoint.matches || group.hasAttribute('data-active');
    });
  }

  syncMenuGroups();
  if (menuBreakpoint.addEventListener) {
    menuBreakpoint.addEventListener('change', syncMenuGroups);
  }

  if (sidebar && toggle) {
    toggle.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = sidebar.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    // Tutup sidebar saat klik di luar atau tekan Escape
    document.addEventListener('click', function (e) {
      if (sidebar.classList.contains('open') && !sidebar.contains(e.target)) {
        sidebar.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
      }
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && sidebar.classList.contains('open')) {
        sidebar.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
      }
    });
  }

  // Konfirmasi sebelum menghapus data
  document.addEventListener('submit', function (e) {
    var msg = e.target.getAttribute('data-confirm');
    if (msg && !window.confirm(msg)) { e.preventDefault(); }
  });
});
