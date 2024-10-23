// SORT BY

const sortbyBtn = document.querySelector('.sortby-btn');

sortbyBtn.addEventListener('click', function (e) {
    this.classList.toggle('active');
    sortJobVacanciesByDate(filteredData);
});

function sortJobVacanciesByDate(data) {
    // Sort the jobvacancyData array by dateCreated in descending order
    data.sort((a, b) => new Date(b.dateCreated) - new Date(a.dateCreated));

    // Re-render the job vacancy cards and pagination
    generateJobVacancyCards(filteredData);
    generatePagination(filteredData);
}