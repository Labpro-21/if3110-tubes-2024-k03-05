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
        aboutInput.value = quill.root.innerHTML; 

        if(quill.getText().trim().length === 0){
            alert('Please enter about.');
            return;
        }
    });

    quill.on('text-change', function() {
        aboutInput.value = quill.root.innerHTML; 
    });
});
