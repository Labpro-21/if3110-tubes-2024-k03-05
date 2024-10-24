document.getElementById('applicantForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();

    xhr.open('POST', '/editProfileJobseeker', true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            const response = JSON.parse(xhr.responseText);
            if (xhr.status === 200) {
                showToast(response.message, 'success');
                window.location.href = '/profile';
            } else {
                showToast(response.message, 'error');
            }
        }
    };

    xhr.send(formData);
});

function showToast(message, type) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = `toast show ${type}`;
    setTimeout(() => {
        toast.className = toast.className.replace('show', '');
    }, 3000);
}