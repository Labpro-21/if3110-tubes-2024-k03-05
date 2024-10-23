function updatePageInUrl(page, searchTerm = '') {
    let url = new URL(window.location.href);
    url.searchParams.set('page', page);
    if (searchTerm) {
        url.searchParams.set('search', searchTerm);
    }
    window.location.href = url.toString();
}