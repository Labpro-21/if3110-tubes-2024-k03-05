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
    const category = e.target.dataset.id.toLowerCase();

    // Filter job vacancies by category
    filteredData = category === 'All'
      ? jobvacancyData // Show all if 'All' is selected
      : jobvacancyData.filter(data => data.jenisJob.toLowerCase() === category);

    currentPage = 1; // Reset to the first page

    generateJobVacancyCards(filteredData);
    generatePagination(filteredData);
  });
});
