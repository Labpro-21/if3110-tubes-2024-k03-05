document.addEventListener('DOMContentLoaded', function() {
    // Quill
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

    // Attachment
    const attachmentList = document.getElementById('attachment-container');

    // Handle removal of existing attachments
    attachmentList.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-attachment')) {
            const listItem = event.target.closest('.attachment');
            const button = listItem.querySelector('button[type="button"]');
            const attachmentId = button.name;
    
            console.log('Removing attachment with ID:', attachmentId);
    
            // Send delete request to the endpoint
            const xhr = new XMLHttpRequest();
            xhr.open('DELETE', `/deleteAttachment?attachmentId=${attachmentId}`, true);
    
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log('Attachment removed successfully.');
                        // Remove the attachment from the DOM
                        listItem.remove();
                    } else {
                        console.error('Failed to delete attachment:', xhr.status);
                    }
                }
            };
    
            xhr.send();
        }
    });

    // Attachment input
    const attachmentInput = document.getElementById('Attachment');
    const attachmentCountInput = document.getElementById('AttachmentCount');

    attachmentInput.addEventListener('change', function() {
        const fileCount = attachmentInput.files.length;
        attachmentCountInput.value = fileCount;
    });
});

document.getElementById('jobForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    const xhr = new XMLHttpRequest();

    xhr.open('POST', '/editLowongan', true);

    xhr.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 201) {
                showToast('Lowongan berhasil diubah!');
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 1000);
            } else {
                showToast('Gagal mengubah lowongan.', 'error');
            }
        }
    };

    xhr.send(formData);
});

const attachmentCount = document.getElementById('attachmentCount');

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