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

    quill.on('text-change', function() {
        const descriptionInput = document.getElementById('aboutInput');
        descriptionInput.value = quill.root.innerHTML;
    });

    const aboutInput = document.getElementById('aboutInput');
    const form = document.getElementById('applicantForm');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        aboutInput.value = quill.root.innerHTML;
        if(quill.getText().trim().length === 0){
            showToast('About field cannot be empty', 'error');
            return;
        }

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        xhr.open('POST', '/editProfileCompany', true);

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