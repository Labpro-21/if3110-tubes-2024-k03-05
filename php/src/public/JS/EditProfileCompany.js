document.addEventListener('DOMContentLoaded', function() {
    const quill = new Quill('#editor', {
        modules: {
            toolbar: [
                ['bold', 'italic'],
                ['link', 'blockquote', 'code-block'],
                [{ list: 'ordered' }, { list: 'bullet' }],
            ],
        },
        theme: 'snow',
    });

    const aboutInput = document.getElementById('aboutInput');
    const form = document.querySelector('form');

    quill.root.innerHTML = aboutInput.value;

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        aboutInput.value = quill.root.innerHTML;
        if(quill.getText().trim().length === 0){
            showToast('About field cannot be empty', 'error');
            return;
        }

        const formData = {
            name: document.getElementById('name').value,
            about: quill.root.innerHTML,
            email: document.getElementById('email').value,
            location: document.getElementById('location').value
        };

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/editProfileCompany', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                const response = JSON.parse(xhr.responseText);
                if (xhr.status === 200) {
                    showToast(response.message, 'success');
                    window.location.href = '/Companyprofile';
                } else {
                    showToast(response.message, 'error');
                }
            }
        };

        xhr.send(JSON.stringify(formData));
    });

    quill.on('text-change', function() {
        aboutInput.value = quill.root.innerHTML; 
    });
});

function showToast(message, type) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = `toast show ${type}`;
    setTimeout(() => {
        toast.className = toast.className.replace('show', '');
    }, 3000);
}