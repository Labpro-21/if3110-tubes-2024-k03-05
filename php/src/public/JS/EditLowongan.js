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

    const descriptionInput = document.getElementById('descriptionInput');
    const companyForm = document.querySelector('form');

    quill.root.innerHTML = descriptionInput.value; 

    companyForm.addEventListener('submit', function(event) {
        descriptionInput.value = quill.root.innerHTML; 

        if (!descriptionInput.value.trim()) {
            alert('Deskripsi tidak boleh kosong!');
            event.preventDefault();
        }
    });

    // Update the hidden input when the content of the editor changes
    quill.on('text-change', function() {
        descriptionInput.value = quill.root.innerHTML; // Menyimpan HTML
    });
});
