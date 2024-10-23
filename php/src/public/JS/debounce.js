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

function searchJobs() {
    const searchTerm = document.getElementById('searchInput').value;
    const url = new URL(window.location.href);
    url.searchParams.set('search', searchTerm);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

document.getElementById('searchInput').addEventListener('input', debounce(searchJobs, 300));
