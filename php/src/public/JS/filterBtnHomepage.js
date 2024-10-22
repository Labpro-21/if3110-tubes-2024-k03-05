const dropdownBtn = document.querySelector('.dropdown-btn');;

const linksEL = document.querySelectorAll('.dropdown-content a');

linksEL.forEach(link => {
  link.addEventListener('click', (e) => {
    const category = e.target.dataset.id.toLowerCase();

    // Filter job vacancies by category
    filteredData = category === 'All'
      ? requestAllJobs()
      :

    currentPage = 1; // Reset to the first page

    generateJobVacancyCards(filteredData);
    generatePagination(filteredData);
  });
});

function requestAllJobs(){
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      return this.responseText;
    }
  };

  xhttp.open("GET", "/getAllJobs", true);
  xhttp.send();
}

function requestCategoryJobs(category){
  const xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      return this.responseText;
    }
  };

  xhttp.open("GET", `/getCategoryJobs?category=${category}`, true);
  xhttp.send();
}
