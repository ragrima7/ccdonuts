document.addEventListener('DOMContentLoaded', function() {
  const drawer = document.querySelector('.drawer');
  const openBtn = document.getElementById('openDrawer');
  const closeBtn = document.getElementById('closeDrawer');
  const overlay = document.querySelector('.overlay');

  if (openBtn && drawer && overlay) {
    openBtn.addEventListener('click', () => {
      drawer.classList.add('active');
      overlay.classList.add('active');
    });
  }

  if (closeBtn && drawer && overlay) {
    closeBtn.addEventListener('click', () => {
      drawer.classList.remove('active');
      overlay.classList.remove('active');
    });
  }
});