/* FILTER JOB */

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


/*  FILTER LOCATION */
const dropdownBtnLoc = document.querySelector('.dropdownLoc-btn');

dropdownBtnLoc.addEventListener('click', function () {
  const dropdown = this.parentElement;
  dropdown.classList.toggle('show');
  this.classList.toggle('active');
});

window.addEventListener('click', function (e) {
  if (!e.target.matches('.dropdownLoc-btn')) {
    document.querySelectorAll('.dropdownLoc').forEach(dropdown => dropdown.classList.remove('show'));
    dropdownBtnLoc.classList.remove('active');
  }
});




/*  FILTER BY CATEGORY */

const linksLocEL = document.querySelectorAll('.dropdownLoc-content a');

linksLocEL.forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const category = e.target.dataset.id.toLowerCase();
    const url = new URL(window.location.href);
    url.searchParams.set('categoryLoc', category);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
  });
});