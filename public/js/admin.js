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

  document.querySelectorAll('[data-package-editor]').forEach(function (editor) {
    var list = editor.querySelector('[data-package-list]');
    var template = editor.querySelector('[data-package-template]');
    var addButton = editor.querySelector('[data-add-package]');
    var nextIndex = Number(editor.dataset.nextIndex || 0);

    if (list && template && addButton) {
      addButton.addEventListener('click', function () {
        var rowTemplate = document.createElement('template');
        rowTemplate.innerHTML = template.innerHTML.replaceAll('__INDEX__', String(nextIndex++));
        list.appendChild(rowTemplate.content);
      });

      editor.addEventListener('click', function (event) {
        var removeButton = event.target.closest('[data-remove-package]');
        if (removeButton) {
          removeButton.closest('[data-package-row]').remove();
        }
      });
    }
  });

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
