<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../public/CSS/register.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>

<div class="container" id="signin">
    <div class="box form-box">
        <header>Sign Up</header>
        <p>Stay updated on your professional world.</p>

        <!-- Job Seeker Form -->
        <form id="jobseekerForm" class="active-form">
            <input type="hidden" name="role" value="jobseeker">
            <div class="input-group">
                <input type="text" name="name" placeholder="Name" required id="nameJobSeeker">
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
        <form id="companyForm" style="display: none;">
            <input type="hidden" name="role" value="company">
            <div class="input-group">
                <input type="text" name="name" placeholder="Name" required id="nameCompany">
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
                <input type="password" name="confirmPassword" placeholder="Confirm Password" required id="confirmPasswordCompany">
                <label for="confirmPassword">Confirm Password</label>
                <span id="toggleConfirmPasswordCompany" onclick="togglePassword('confirmPasswordCompany', 'toggleConfirmPasswordCompany')"></span>
            </div>
            <div class="input-group">
                <input type="text" name="location" placeholder="Location" required id="location">
                <label for="location">Location</label>
            </div>
            <div class="input-group">
                <p>About The Company</p>
                <div id="editor"></div>
                <input type="hidden" name="about" id="aboutInput" required>
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
    <div class="links">
        Already on LinkInPurry?
        <a href="/login">Sign in</a>
    </div>
    <div id="toast" class="toast"></div>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="../public/JS/Register.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

</body>
</html>
