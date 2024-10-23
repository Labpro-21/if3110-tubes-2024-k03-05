// SORT BY
const sortbyBtn = document.querySelector('.sortBy-btn');

sortbyBtn.addEventListener('click', function () {
  const dropdown = this.parentElement;
  dropdown.classList.toggle('show');
  this.classList.toggle('active'); // Toggle green background
});

window.addEventListener('click', function (e) {
  if (!e.target.matches('.sortBy-btn')) {
    document.querySelectorAll('.sortBy').forEach(dropdown => dropdown.classList.remove('show'));
    sortbyBtn.classList.remove('active'); // Remove background when clicking outside
  }
});
