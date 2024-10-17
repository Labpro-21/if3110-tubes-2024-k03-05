const jobvacancyData = [
    { posisi: "Software Engineer", deskripsi: "Develop and maintain web applications.", jenisJob: "Full-time", jenisLokasi: "hybrid", image: "https://via.placeholder.com/50", dateCreated: "2023-09-01" },
    { posisi: "Marketing Intern", deskripsi: "Assist in executing marketing campaigns.", jenisJob: "Internship", jenisLokasi: "remote", image: "https://via.placeholder.com/50", dateCreated: "2023-10-25" },
    { posisi: "Data Analyst", deskripsi: "Analyze business data to identify trends and insights.", jenisJob: "Full-time", jenisLokasi: "on-site", image: "https://via.placeholder.com/50", dateCreated: "2023-08-20" },
    { posisi: "Graphic Designer", deskripsi: "Create visual content for various platforms.", jenisJob: "Part-time", jenisLokasi: "remote", image: "https://via.placeholder.com/50", dateCreated: "2023-09-15" },
    { posisi: "HR Assistant", deskripsi: "Manage recruitment and employee records.", jenisJob: "Full-time", jenisLokasi: "on-site", image: "https://via.placeholder.com/50", dateCreated: "2023-07-10" },
    { posisi: "Product Manager", deskripsi: "Oversee product development lifecycle.", jenisJob: "Full-time", jenisLokasi: "hybrid", image: "https://via.placeholder.com/50", dateCreated: "2023-09-05" },
    { posisi: "UX Designer", deskripsi: "Design intuitive user interfaces.", jenisJob: "Part-time", jenisLokasi: "remote", image: "https://via.placeholder.com/50", dateCreated: "2023-09-01" },
    { posisi: "IT Support", deskripsi: "Provide technical support for employees.", jenisJob: "Full-time", jenisLokasi: "on-site", image: "https://via.placeholder.com/50", dateCreated: "2023-08-25" },
    { posisi: "Content Writer", deskripsi: "Write and edit engaging content.", jenisJob: "Part-time", jenisLokasi: "remote", image: "https://via.placeholder.com/50", dateCreated: "2023-08-20" },
    { posisi: "Business Analyst", deskripsi: "Analyze business processes and recommend improvements.", jenisJob: "Full-time", jenisLokasi: "hybrid", image: "https://via.placeholder.com/50", dateCreated: "2023-10-15" }
];
  
  const cardsPerPage = 5;
  let currentPage = 1; // Track the current page
  let filteredData = jobvacancyData; // Default is the full data
  
  function generateJobVacancyCards(data) {
    const container = document.getElementById('jobvacancy-cards');
    container.innerHTML = ''; // Clear previous cards
  
    const startIndex = (currentPage - 1) * cardsPerPage;
    const endIndex = startIndex + cardsPerPage;
    const currentData = data.slice(startIndex, endIndex); // Use sliced data for current page
  
    currentData.forEach(item => {
      const card = document.createElement('div');
      card.className = 'jobvacancy-card';
  
      card.innerHTML = `
        <img src="${item.image}" alt="${item.posisi}">
        <div class="jobvacancy-info">
            <div class="job-name-date">
                <a href="#">${item.posisi}</a>
                <span>${new Date(item.dateCreated).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
            </div>
            <p>${item.deskripsi}</p>
            <p>${item.jenisJob} <span>•</span> ${item.jenisLokasi}</p>
        </div>
      `;
      container.appendChild(card);
    });
  }
  
  function generatePagination(data) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = ''; // Clear previous pagination buttons
  
    const totalPages = Math.ceil(data.length / cardsPerPage); // Calculate pages from filtered data
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
  
    // Page Numbers with Ellipsis Logic
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
  
    // Next Button
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
  
  // Initial render
  generateJobVacancyCards(filteredData);
  generatePagination(filteredData);
  
  