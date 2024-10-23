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

    const companyForm = document.querySelector('form');

    companyForm.addEventListener('submit', function(event) {
        const descriptionInput = document.getElementById('descriptionInput');
        descriptionInput.value = quill.root.innerHTML;

        if(quill.getText().trim().length === 0){
            alert('Please enter description.');
            return;
        }
    });
});
