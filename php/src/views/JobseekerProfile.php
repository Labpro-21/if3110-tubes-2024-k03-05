<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Company</title>
    <link rel="stylesheet" type="text/css" href="../public/CSS/profileCompany.css">
    <link rel="stylesheet" type="text/css" href="../public/CSS/companyHomepageNavbar.css">
</head>
<body>
<?php include 'jobsHomepageNavbar.php'; ?>
<main>
    <section class="profile-company">
        <div class="profile-container">
            <div class="profile-content">
                <div class="profile-banner">
                    <img src="<?php
                    if ($userDetails['banner_path']) {
                        echo '/serveFile?file=' . $userDetails['banner_path'];
                    } else {
                        echo '/public/images/linkedinbanner.webp';
                    }
                    ?>" alt="Banner">
                </div>
                <a href="/editProfileJobseeker" class="editcomprofile-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" style="color: #0a66c2;" viewBox="0 0 24 24"><path fill="currentColor" d="M8.707 19.707L18 10.414L13.586 6l-9.293 9.293a1 1 0 0 0-.263.464L3
                        21l5.242-1.03c.176-.044.337-.135.465-.263M21 7.414a2 2 0 0 0 0-2.828L19.414 3a2 2 0 0 0-2.828 0L15 4.586L19.414 9z"/></svg>
                </a>
                <div class="profile-photo">
                    <img src="<?php
                    if ($userDetails['image_path']) {
                        echo '/serveFile?file=' . $userDetails['image_path'];
                    } else {
                        echo '/public/images/profile-img.webp';
                    }
                    ?>" alt="Profile">
                </div>
                <div class="info-section">
                    <p class="profile-name"><?= $_SESSION['name']; ?></p>
                    <p class="profile-tagline"><?= $userDetails['email']; ?></p>
                    <p class="profile-location"><?= $userDetails['role']; ?> </p>
                </div>
            </div>
        </div>
    </section>
</main>
</body>
</html>
