<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkInPurry</title>
    <link rel="stylesheet" href="../public/CSS/landingPage.css">
    <link rel="stylesheet" href="../public/CSS/guestHomepageNavbar.css">
</head>
<body>
<?php include 'guestNavbar.php'; ?>
    <main>
        <section id="loginRegister">
            <div class="content-wrapper">
                <div class="login-reg">
                    <header>
                        Welcome to your professional community
                    </header>
                    <div class="signIn">
                        <a href="/login">
                            Sign in with email
                        </a>
                    </div>
                    
                    <div class="links">
                        New to LinkInPurry?
                        <a href="/register">Join Now</a>
                    </div>
                </div>
                <div class="picture">
                    <img src="../public/images/landing.webp" alt="profile banner">
                </div>
            </div>
        </section>
        <section id="Post">
            <div class="content">
                <h2>Post your job for millions of people to see</h2>
                <a href="/login">Post a job</a>
            </div>
        </section>
        <section class="last">
        <div class="last-container">
            <div class="logo">
                <img src="../public/images/LinkIn.webp" alt="LinkedIn Logo">
            </div>
            <div class="last-links">
                <div class="last-column">
                    <h4>General</h4>
                    <a href="/register">Sign Up</a>
                    <a href="/login">Sign In</a>
                </div>
                <div class="last-column">
                    <h4>Browse LinkInPurry</h4>
                    <a href="/dashboard">Jobs</a>
                </div>
            </div>
    </div>
        </section>
    </main>
</body>
</html>