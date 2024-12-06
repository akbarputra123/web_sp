document.addEventListener('DOMContentLoaded', function() {
  const menuDropdown = document.querySelector('.menu-item-menutup');
  menuDropdown.addEventListener('click', function(e) {
    if (e.target.closest('.menu-item')) {
      this.classList.toggle('active');
    }
  });
});

