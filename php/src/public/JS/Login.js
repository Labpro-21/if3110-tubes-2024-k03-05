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