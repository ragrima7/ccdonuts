/* scripts/main.js */

// scripts/main.js (場所: scripts/main.js)

document.addEventListener('DOMContentLoaded', function() {
  const drawer = document.querySelector('.drawer');
  const overlay = document.querySelector('.overlay');
  const openBtn = document.getElementById('openDrawer');
  const closeBtn = document.getElementById('closeDrawer');

  openBtn.addEventListener('click', () => {
    drawer.classList.add('open');
    overlay.classList.add('show');
  });

  closeBtn.addEventListener('click', () => {
    drawer.classList.remove('open');
    overlay.classList.remove('show');
  });

  overlay.addEventListener('click', () => {
    drawer.classList.remove('open');
    overlay.classList.remove('show');
  });
});
