let params = new URLSearchParams();

function fetchJobs(params) {
    const url = new URL('/getFilteredJobsComp', window.location.origin);
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

    function capitalizeFirstLetter(jenis_pekerjaan) {
        return jenis_pekerjaan.charAt(0).toUpperCase() + jenis_pekerjaan.slice(1);
    }

    if (jobs.length === 0) {
        const noJobsMessage = document.createElement('p');
        noJobsMessage.className = 'no-jobs-message';
        noJobsMessage.textContent = "No job vacancy";
        jobContainer.appendChild(noJobsMessage);
    } else {
        jobs.forEach(job => {
            const jobCard = document.createElement('div');
            jobCard.className = 'job-card';
            jobCard.innerHTML = `
                <div class="jobvacancy-info">
                    <div>
                        <img src="https://imageplaceholder.net/600x400" class="jobvacancy-photo">
                    </div>
                    <div>
                        <div class="job-name-date">
                            <a href="/detailLowonganCompany?lowonganId=${job.lowongan_id}">${job.posisi}</a>
                            <span>Posted on ${new Date(job.created_at).toLocaleDateString()}</span>
                        </div>
                        <div class="comp">
                            <p class="comp-name">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M11.465 9.145c-1.242 0-1.98 1.02-1.98 2.73c0 1.7.738 2.73 1.968 2.73c1.266 0 2.05-1.043 2.05-2.73s-.784-2.73-2.038-2.73m.387-7.125c5.554 0 9.457 3.492 9.457 8.707c0 3.691-1.747 6.07-4.606 6.07c-1.453 0-2.566-.703-2.824-1.84h-.164c-.48 1.172-1.465 1.805-2.824 1.805c-2.438 0-4.067-1.98-4.067-4.957c0-2.848 1.606-4.793 3.95-4.793c1.265 0 2.32.633 2.777 1.664h.164V7.27h2.379v6.27c0 .808.375 1.323 1.113 1.323c1.148 0 1.945-1.465 1.945-3.96c0-4.266-2.941-7.02-7.382-7.02c-4.512 0-7.676 3.258-7.676 7.969c0 4.933 3.293 7.816 8.12 7.816c1.255 0 2.532-.164 3.2-.41v1.875c-.914.27-2.11.433-3.375.433c-5.93 0-10.101-3.714-10.101-9.773c0-5.813 4.066-9.773 9.914-9.773"/></svg>
                                ${job.nama}
                            </p>
                        </div>
                        <p class="job-desc">${job.deskripsi}</p>
                        <p class="job-loc">${capitalizeFirstLetter(job.jenis_pekerjaan)} • ${capitalizeFirstLetter(job.jenis_lokasi)}</p>
                    </div>
                </div>
            `;
            jobContainer.appendChild(jobCard);
        });
    }
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
        prevButton.onclick = () => {
            params.set('page', (currentPage - 1).toString());
            fetchJobs(params);
        }
        pagination.appendChild(prevButton);
    }

    let startPage = Math.max(1, currentPage - Math.floor(maxVisibleButtons / 2));
    let endPage = startPage + maxVisibleButtons - 1;

    if (endPage > totalPages) {
        endPage = totalPages;
        startPage = Math.max(1, endPage - maxVisibleButtons + 1);
    }

    if (startPage > 1) {
        const firstButton = createButton(1);
        firstButton.onclick = () => {
            params.set('page', '1');
            fetchJobs(params);
        }
        pagination.appendChild(firstButton);
        if (startPage > 2) addEllipsis();
    }

    for (let i = startPage; i <= endPage; i++) {
        const pageButton = createButton(i, i === currentPage);
        pageButton.onclick = () => {
            params.set('page', i.toString());
            fetchJobs(params);
        };
        pagination.appendChild(pageButton);
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) addEllipsis();
        const lastButton = createButton(totalPages);
        lastButton.onclick = () => {
            params.set('page', totalPages.toString());
            fetchJobs(params);
        }
        pagination.appendChild(lastButton);
    }

    // Next Button
    if (currentPage < totalPages) {
        const nextButton = createButton('>');
        nextButton.onclick = () => {
            params.set('page', (currentPage + 1).toString());
            fetchJobs(params);
        };
        pagination.appendChild(nextButton);
    }
}

document.getElementById('searchInput').addEventListener('input', debounce(() => {
    const searchTerm = document.getElementById('searchInput').value;
    params.set('search', searchTerm);
    params.set('page', '1');
    fetchJobs(params);
}, 500));


/*  FILTER BY CATEGORY */

const linksEL = document.querySelectorAll('.dropdown-content a');

linksEL.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const category = e.target.dataset.id.toLowerCase();
        params.set('category', category);
        params.set('page', '1');
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
        params.set('page', '1');
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
        params.set('page', '1');
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


