const dropdownBtn = document.querySelector('.dropdown-btn');

dropdownBtn.addEventListener('click', function () {
  const dropdown = this.parentElement;
  dropdown.classList.toggle('show');
  this.classList.toggle('active'); // Toggle green background
});

window.addEventListener('click', function (e) {
  if (!e.target.matches('.dropdown-btn')) {
    document.querySelectorAll('.dropdown').forEach(dropdown => dropdown.classList.remove('show'));
    dropdownBtn.classList.remove('active'); // Remove background when clicking outside
  }
});

const linksEL = document.querySelectorAll('.dropdown-content a');

linksEL.forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const category = e.target.dataset.id.toLowerCase();
    const url = new URL(window.location.href);
    url.searchParams.set('category', category);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
  });
});
