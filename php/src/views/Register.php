<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

use config\Database;
use models\User;

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashing the password

    // Check if it's a Job Seeker or Company form
    if (isset($_POST['registerJobSeeker'])) {
        // Job Seeker registration
        $sql = "INSERT INTO job_seekers (name, email, password) VALUES ('$name', '$email', '$password')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        echo "Job Seeker Registered!";
    } elseif (isset($_POST['registerCompany'])) {
        // Company registration
        $location = $_POST['location'];
        $about = $_POST['about'];
        $sql = "INSERT INTO companies (name, email, password, location, about) VALUES ('$name', '$email', '$password', '$location', '$about')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        echo "Company Registered!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../public/CSS/register.css">
    <script src="../public/JS/Register.js"></script>
</head>
<body>

<div class="container" id="signin">
    <div class="box form-box">
        <header>Sign Up</header>
        <p>Stay updated on your professional world.</p>

        <!-- Job Seeker Form -->
        <form id="jobseekerForm" action="Register.php" method="POST" class="active-form">
            <div class="input-group">
                <input type="text" name="name" placeholder="Name" required>
                <label for="name">Name</label>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required id="emailJobSeeker">
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required id="passwordJobSeeker">
                <label for="password">Password</label>
                <span id="togglePasswordJobSeeker" onclick="togglePassword('passwordJobSeeker', 'togglePasswordJobSeeker')"></span>
            </div>
            <div class="input-group">
                <input type="password" name="confirmPassword" placeholder="Confirm Password" required id="confirmPasswordJobSeeker">
                <label for="confirmPassword">Confirm Password</label>
                <span id="toggleConfirmPasswordJobSeeker" onclick="togglePassword('confirmPasswordJobSeeker', 'toggleConfirmPasswordJobSeeker')"></span>
            </div>
            <div class="role">
                Join as?
            </div>
            <div class="role-btn">
                <button type="button" id="jobseekerBtn" class="role active">Job Seeker</button>
                <button type="button" id="companyBtn" class="role">Company</button>
            </div>
            <input type="submit" class="btn" value="Sign Up" name="registerJobSeeker">
        </form>

        <!-- Company Form -->
        <form id="companyForm" action="Register.php" method="POST" style="display: none;">
            <div class="input-group">
                <input type="text" name="name" placeholder="Name" required>
                <label for="name">Name</label>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required id="emailCompany">
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required id="passwordCompany">
                <label for="password">Password</label>
                <span id="togglePasswordCompany" onclick="togglePassword('passwordCompany', 'togglePasswordCompany')"></span>
            </div>
            <div class="input-group">
                <input type="password" name="confirmPassword" placeholder="Confirm Password" required id="confirmPasswordJobSeeker">
                <label for="confirmPassword">Confirm Password</label>
                <span id="toggleConfirmPasswordJobSeeker" onclick="togglePassword('confirmPasswordJobSeeker', 'toggleConfirmPasswordJobSeeker')"></span>
            </div>
            <div class="input-group">
                <input type="text" name="location" placeholder="Location" required>
                <label for="location">Location</label>
            </div>
            <div class="input-group">
                <input type="text" name="about" placeholder="About" required>
                <label for="about">About</label>
            </div>
            <div class="role">
                Join as?
            </div>
            <div class="role-btn">
                <button type="button" id="jobseekerBtnCompany" class="role">Job Seeker</button>
                <button type="button" id="companyBtn" class="role active">Company</button>
            </div>
            <input type="submit" class="btn" value="Sign Up" name="registerCompany">
        </form>

    </div>
</div>

<script>
    const jobseekerBtn = document.getElementById('jobseekerBtn');
    const companyBtn = document.getElementById('companyBtn');
    const jobseekerForm = document.getElementById('jobseekerForm');
    const companyForm = document.getElementById('companyForm');

    jobseekerBtn.addEventListener('click', () => {
        jobseekerForm.style.display = 'block';
        companyForm.style.display = 'none';
        jobseekerBtn.classList.add('active');
        companyBtn.classList.remove('active');
    });

    companyBtn.addEventListener('click', () => {
        jobseekerForm.style.display = 'none';
        companyForm.style.display = 'block';
        companyBtn.classList.add('active');
        jobseekerBtn.classList.remove('active');
    });

    jobseekerBtnCompany.addEventListener('click', () => {
    jobseekerForm.style.display = 'block';
    companyForm.style.display = 'none';
    jobseekerBtn.classList.add('active');
    companyBtn.classList.remove('active');
    });

</script>

</body>
</html>
