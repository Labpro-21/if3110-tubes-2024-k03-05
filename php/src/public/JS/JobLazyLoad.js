document.addEventListener('DOMContentLoaded', function() {
    let page = 1;
    const limit = 10;
    let loading = false;

    window.addEventListener('scroll', function() {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500 && !loading) {
            loadMoreJobs();
        }
    });

    function loadMoreJobs() {
        loading = true;
        page++;

        fetch(`/api/jobs?page=${page}&limit=${limit}`)
            .then(response => response.json())
            .then(data => {
                const jobListings = document.getElementById('jobListings');
                const tbody = jobListings.querySelector('tbody');

                data.forEach(job => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${job.id}</td>
                        <td>${job.title}</td>
                        <td>${job.company}</td>
                    `;
                    tbody.appendChild(row);
                });

                loading = false;
            })
            .catch(error => {
                console.error('Error:', error);
                loading = false;
            });
    }
});
