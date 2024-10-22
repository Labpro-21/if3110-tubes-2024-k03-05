const cardsPerPage = 5;
let currentPage = 1;

function generatePagination(data) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    const totalPages = Math.ceil(data.length / cardsPerPage);
    const maxVisiblePages = 5;

    const createButton = (text, disabled = false, active = false) => {
        const button = document.createElement('button');
        button.textContent = text;

        if (disabled) button.classList.add('disabled');
        if (active) button.classList.add('active');
        return button;
    };

    // Previous Button
    const prevButton = createButton('<', currentPage === 1);
    prevButton.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            generateJobVacancyCards(filteredData);
            generatePagination(filteredData);
        }
    });
    pagination.appendChild(prevButton);


    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (startPage > 1) pagination.appendChild(createButton('1'));
    if (startPage > 2) pagination.appendChild(createButton('...'));

    for (let i = startPage; i <= endPage; i++) {
        const pageButton = createButton(i, false, i === currentPage);
        pageButton.addEventListener('click', () => {
            currentPage = i;
            generateJobVacancyCards(filteredData);
            generatePagination(filteredData);
        });
        pagination.appendChild(pageButton);
    }

    if (endPage < totalPages - 1) pagination.appendChild(createButton('...'));
    if (endPage < totalPages) pagination.appendChild(createButton(totalPages));

    const nextButton = createButton('>', currentPage === totalPages);
    nextButton.addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            generateJobVacancyCards(filteredData);
            generatePagination(filteredData);
        }
    });
    pagination.appendChild(nextButton);
}


  