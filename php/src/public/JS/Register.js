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

