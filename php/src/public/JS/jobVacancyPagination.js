// const cardsPerPage = 5;
// let currentPage = 1; // Track the current page

// function generatePagination(data) {
//     const pagination = document.getElementById('pagination');
//     pagination.innerHTML = ''; // Clear previous pagination buttons

//     const totalPages = Math.ceil(data.length / cardsPerPage); // Calculate pages from filtered data

//     const createButton = (text, disabled = false, active = false) => {
//         const button = document.createElement('button');
//         button.textContent = text;

//         if (disabled) button.classList.add('disabled');
//         if (active) button.classList.add('active');
//         return button;
//     };

//     // Previous Button
//     const prevButton = createButton('<', currentPage === 1);
//     prevButton.addEventListener('click', () => {
//         if (currentPage > 1) {
//             currentPage--;
//             updatePageInUrl(currentPage);
//         }
//     });
//     pagination.appendChild(prevButton);

//     // Page Numbers
//     for (let i = 1; i <= totalPages; i++) {
//         const pageButton = createButton(i, false, i === currentPage);
//         pageButton.addEventListener('click', () => {
//             currentPage = i;
//             updatePageInUrl(currentPage);
//         });
//         pagination.appendChild(pageButton);
//     }

//     // Next Button
//     const nextButton = createButton('>', currentPage === totalPages);
//     nextButton.addEventListener('click', () => {
//         if (currentPage < totalPages) {
//             currentPage++;
//             updatePageInUrl(currentPage);
//         }
//     });
//     pagination.appendChild(nextButton);
// }

// function updatePageInUrl(page) {
//   const url = new URL(window.location.href);
//   url.searchParams.set('page', page);
//   window.location.href = url.toString();
// }
