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



const linkSortEL = document.querySelectorAll('.sortBy-content a');

linkSortEL.forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const category = e.target.dataset.id.toLowerCase();
    // console.log(category);

    const url = new URL(window.location.href);
    url.searchParams.set('categorySort', category);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
  });
});

// lakukan post ke suatu endpoint yg membuat atribut session baru yg berasal dr post









// function sortJobVacanciesByDate(data) {
//     // Sort the jobvacancyData array by dateCreated in descending order
//     data.sort((a, b) => new Date(b.dateCreated) - new Date(a.dateCreated));
    
//     // Re-render the job vacancy cards and pagination
//     generateJobVacancyCards(filteredData);
//     generatePagination(filteredData);
// }
