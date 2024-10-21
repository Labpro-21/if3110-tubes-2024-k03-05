// SORT BY

const sortbyBtn = document.querySelector('.sortby-btn');

sortbyBtn.addEventListener('click', function (e) {
    sortJobVacanciesByDate(filteredData);
});

function sortJobVacanciesByDate(data) {
    data.sort((a, b) => new Date(b.dateCreated) - new Date(a.dateCreated));
    generateJobVacancyCards(filteredData);
    generatePagination(filteredData);
}