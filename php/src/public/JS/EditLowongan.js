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
    const form = document.querySelector('form');

    quill.root.innerHTML = descriptionInput.value; 

    form.addEventListener('submit', function(event) {
        descriptionInput.value = quill.root.innerHTML; 

        if(quill.getText().trim().length === 0){
            alert('Please enter description.');
            return;
        }
    });

    quill.on('text-change', function() {
        descriptionInput.value = quill.root.innerHTML; 
    });
});
