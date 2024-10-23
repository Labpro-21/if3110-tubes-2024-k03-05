let params = new URLSearchParams();

function fetchJobs(params) {
    const url = new URL('/getFilteredJobs', window.location.origin);
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `${url}?${params.toString()}`, true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                updateJobList(data.jobs);
                updatePagination(data.totalPages, data.currentPage);
            } else {
                console.error('Error:', xhr.statusText);
            }
        }
    };

    xhr.send();
}

function updateJobList(jobs) {
    const jobContainer = document.getElementById('jobvacancy-cards');
    jobContainer.innerHTML = '';

    jobs.forEach(job => {
        const jobCard = document.createElement('div');
        jobCard.className = 'job-card';
        jobCard.innerHTML = `
            <div class="jobvacancy-info">
                <div class="job-name-date">
                    <a href="/detailLowongan${job.lowongan_id}">${job.posisi}</a>
                    <span>Posted on ${new Date(job.created_at).toLocaleDateString()}</span>
                </div>
                <div class="comp">
                    <p class="comp-name">${job.nama}</p>
                </div>
                <p class="job-desc">${job.deskripsi}</p>
                <p class="job-loc">${job.jenis_pekerjaan} • ${job.jenis_lokasi}</p>
            </div>
        `;
        jobContainer.appendChild(jobCard);
    });
}

function updatePagination(totalPages, currentPage) {
    const pagination = document.querySelector('.pagination');
    pagination.innerHTML = '';

    const maxVisibleButtons = 5;

    const createButton = (text, isActive = false) => {
        const button = document.createElement('button');
        button.textContent = text;
        if (isActive) button.classList.add('active');
        return button;
    };

    const addEllipsis = () => {
        const ellipsis = document.createElement('span');
        ellipsis.textContent = '...';
        pagination.appendChild(ellipsis);
    };

    // Previous Button
    if (currentPage > 1) {
        const prevButton = createButton('<');
        prevButton.onclick = () => fetchJobs({page: currentPage - 1});
        pagination.appendChild(prevButton);
    }

    let startPage = Math.max(1, currentPage - Math.floor(maxVisibleButtons / 2));
    let endPage = startPage + maxVisibleButtons - 1;

    if (endPage > totalPages) {
        endPage = totalPages;
        startPage = Math.max(1, endPage - maxVisibleButtons + 1);
    }

    if (startPage > 1) {
        pagination.appendChild(createButton(1));
        if (startPage > 2) addEllipsis();
    }

    for (let i = startPage; i <= endPage; i++) {
        const pageButton = createButton(i, i === currentPage);
        pageButton.onclick = () => fetchJobs({page: i});
        pagination.appendChild(pageButton);
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) addEllipsis();
        pagination.appendChild(createButton(totalPages));
    }

    // Next Button
    if (currentPage < totalPages) {
        const nextButton = createButton('>');
        nextButton.onclick = () => fetchJobs({page: currentPage + 1});
        pagination.appendChild(nextButton);
    }
}

document.getElementById('searchInput').addEventListener('input', debounce(() => {
    const searchTerm = document.getElementById('searchInput').value;
    params.set('search', searchTerm);
    fetchJobs(params);
}, 500));


/*  FILTER BY CATEGORY */

const linksEL = document.querySelectorAll('.dropdown-content a');

linksEL.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const category = e.target.dataset.id.toLowerCase();
        params.set('category', category);
        fetchJobs(params);
    });
});

/*  FILTER BY Loc  */

const linksLocEL = document.querySelectorAll('.dropdownLoc-content a');

linksLocEL.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const category = e.target.dataset.id.toLowerCase();
        params.set('categoryLoc', category);
        fetchJobs(params);
    });
});

/*  SORT BY  */
const linkSortEL = document.querySelectorAll('.sortBy-content a');

linkSortEL.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const category = e.target.dataset.id.toLowerCase();
        params.set('categorySort', category);
        fetchJobs(params);
    });
});

function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        timeoutId = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}


