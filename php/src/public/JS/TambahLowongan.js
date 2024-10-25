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
        const descriptionInput = document.getElementById('descriptionInput');
        descriptionInput.value = quill.root.innerHTML;
    });

    const companyForm = document.querySelector('form');
    companyForm.addEventListener('submit', function(event) {
        event.preventDefault();
        if(quill.getText().trim().length === 0){
            showToast('Deskripsi perusahaan tidak boleh kosong');
        }
    });
});


document.getElementById('jobForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();

    xhr.open('POST', '/tambahLowongan', true);

    xhr.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 201) {
                showToast('Lowongan berhasil ditambahkan!');
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 1000);
            } else {
                showToast('Gagal menambahkan lowongan.');
            }
        }
    };

    xhr.send(formData);
});

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = 'toast';

    if (type === 'error') {
        toast.classList.add('error');
    }

    if (type === 'success') {
        toast.classList.add('success');
    }

    toast.innerText = message;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
