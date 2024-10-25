let type;

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
        type = "jobseeker";
    });

    companyBtn.addEventListener('click', () => {
        copyDataToCompanyForm();
        jobseekerForm.style.display = 'none';
        companyForm.style.display = 'block';
        companyBtn.classList.add('active');
        jobseekerBtn.classList.remove('active');
        type = "company";
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

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    jobseekerForm.addEventListener('submit', function(event) {
        event.preventDefault();
        if (!validateEmail(emailInputJobSeeker.value)) {
            showToast('Please enter a valid email address.', 'error');
            return;
        }
        onsubmit()
    });

    companyForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const description = document.querySelector('input[name="about"]');
        description.value = quill.root.innerHTML;
        if (!validateEmail(emailInputCompany.value)) {
            showToast('Please enter a valid email address.', 'error');
            return;
        }
        if(quill.getText().trim().length === 0){
            showToast('Please enter a description.', 'error');
            return;
        }
        onsubmit()
    });

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

    function onsubmit() {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", "http://localhost:80/register", true);

        xmlhttp.setRequestHeader("Content-Type", "application/json");

        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                if (this.status === 201) {
                    showToast("Registration successful", "success");
                    setTimeout(() => {
                        window.location.href = "http://localhost:80/login";
                    }, 2000);
                } else if (this.status === 400) {
                    showToast("Email already exists", "error");
                } else if (this.status === 500) {
                    showToast("Server error", "error");
                }
            }
        };

        if (type === "company") {
            const name = document.getElementById('nameCompany').value;
            const email = document.getElementById('emailCompany').value;
            const password = document.getElementById('passwordCompany').value;
            const location = document.getElementById('location').value;


            xmlhttp.send(JSON.stringify({
                name: name,
                email: email,
                password: password,
                type: 'company',
                location: location,
                description: quill.root.innerHTML
            }));

        } else {
            const name = document.getElementById('nameJobSeeker').value;
            const email = document.getElementById('emailJobSeeker').value;
            const password = document.getElementById('passwordJobSeeker').value;
            xmlhttp.send(JSON.stringify({
                name: name,
                email: email,
                password: password,
                type: 'jobseeker'
            }));
        }
    }
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



function showToast(message, type) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = `toast show ${type}`;
    setTimeout(() => {
        toast.className = toast.className.replace('show', '');
    }, 3000);
}

