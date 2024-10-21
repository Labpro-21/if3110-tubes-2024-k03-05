document.addEventListener('DOMContentLoaded', function() {
    const jobseekerBtn = document.getElementById('jobseekerBtn');
    const companyBtn = document.getElementById('companyBtn');
    const jobseekerForm = document.getElementById('jobseekerForm');
    const companyForm = document.getElementById('companyForm');
    const nameInputJobSeeker = jobseekerForm.querySelector('input[name="name"]');
    const emailInputJobSeeker = jobseekerForm.querySelector('input[name="email"]');
    const nameInputCompany = companyForm.querySelector('input[name="name"]');
    const emailInputCompany = companyForm.querySelector('input[name="email"]');

    function copyDataToCompanyForm() {
        nameInputCompany.value = nameInputJobSeeker.value;
        emailInputCompany.value = emailInputJobSeeker.value;
    }

    function copyDataToJobSeekerForm() {
        nameInputJobSeeker.value = nameInputCompany.value;
        emailInputJobSeeker.value = emailInputCompany.value;
    }

    jobseekerBtn.addEventListener('click', () => {
        jobseekerForm.style.display = 'block';
        companyForm.style.display = 'none';
        jobseekerBtn.classList.add('active');
        companyBtn.classList.remove('active');
    });

    companyBtn.addEventListener('click', () => {
        copyDataToCompanyForm();
        jobseekerForm.style.display = 'none';
        companyForm.style.display = 'block';
        companyBtn.classList.add('active');
        jobseekerBtn.classList.remove('active');
    });

    document.getElementById('jobseekerBtnCompany').addEventListener('click', () => {
        copyDataToJobSeekerForm();
        jobseekerForm.style.display = 'block';
        companyForm.style.display = 'none';
        jobseekerBtn.classList.add('active');
        companyBtn.classList.remove('active');
    });

    const passwordJobSeeker = document.getElementById('passwordJobSeeker');
    const confirmPasswordJobSeeker = document.getElementById('confirmPasswordJobSeeker');
    const passwordCompany = document.getElementById('passwordCompany');
    const confirmPasswordCompany = document.getElementById('confirmPasswordCompany');

    passwordJobSeeker.addEventListener('blur', () => {
        confirmPasswordJobSeeker.addEventListener('input', validatePasswordJobSeeker);
    });

    passwordCompany.addEventListener('blur', () => {
        confirmPasswordCompany.addEventListener('input', validatePasswordCompany);
    });

    function validatePasswordJobSeeker() {
        if (passwordJobSeeker.value !== confirmPasswordJobSeeker.value) {
            confirmPasswordJobSeeker.setCustomValidity('Passwords do not match');
            confirmPasswordJobSeeker.reportValidity(); 
        } else {
            confirmPasswordJobSeeker.setCustomValidity('');
        }
    }

    function validatePasswordCompany() {
        if (passwordCompany.value !== confirmPasswordCompany.value) {
            confirmPasswordCompany.setCustomValidity('Passwords do not match');
            confirmPasswordCompany.reportValidity(); 
        } else {
            confirmPasswordCompany.setCustomValidity('');
        }
    }

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
});


function togglePassword(id, toggleBtn) {
    const passwordField = document.getElementById(id);
    const toggleButton = document.getElementById(toggleBtn);
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleButton.textContent = "Hide";
    } else {
        passwordField.type = "password";
        toggleButton.textContent = "Show";
    }
}

document.getElementById('emailJobSeeker').addEventListener('input', function (e) {
    const email = e.target.value;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address");
    }
});

