// Initialize Quill editor
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

companyForm.addEventListener('submit', function(event) {
    const aboutInput = document.getElementById('aboutInput');
    aboutInput.value = quill.root.innerHTML; 
});