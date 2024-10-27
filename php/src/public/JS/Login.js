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

document.addEventListener('DOMContentLoaded', function() {});

function onsubmit(e){
    e.preventDefault();

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "http://localhost:80/login", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            const response = JSON.parse(this.responseText);
            showToast(response.message, "success");
            setTimeout(
                () => {
                    window.location.href = "http://localhost:80/dashboard";
                }, 2000
            )
        }

        if (this.readyState === 4 && this.status === 401) {
            const response = JSON.parse(this.responseText);
            showToast(response.message, "error");
        }
    }

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    xmlhttp.send(JSON.stringify({
        email: email,
        password: password,
    }));
}


document.querySelector('form').addEventListener('submit', onsubmit);

function showToast(message, type) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = `toast show ${type}`;
    setTimeout(() => {
        toast.className = toast.className.replace('show', '');
    }, 3000);
}