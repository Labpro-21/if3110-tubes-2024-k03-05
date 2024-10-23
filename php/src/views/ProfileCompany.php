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
<?php include 'companyNavbar.php'; ?>
<main>
    <section class="profile-company">
        <div class="profile-container">
            <div class="profile-content">
                <div class="profile-banner">
<!--                    <img src="--><?php //= $companyData['bannerSrc']; ?><!--" alt="profile banner">-->
                    <img src="../public/images/linkedinbanner.jpg" alt="profile banner">
                </div>
                <a href="#" class="editcomprofile-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" style="color: #0a66c2;" viewBox="0 0 24 24"><path fill="currentColor" d="M8.707 19.707L18 10.414L13.586 6l-9.293 9.293a1 1 0 0 0-.263.464L3
                        21l5.242-1.03c.176-.044.337-.135.465-.263M21 7.414a2 2 0 0 0 0-2.828L19.414 3a2 2 0 0 0-2.828 0L15 4.586L19.414 9z"/></svg>
                </a>
                <div class="profile-photo">
<!--                    <img src="--><?php //= $companyData['photoSrc']; ?><!--" alt="Profile Picture">-->
                    <img src="../public/images/paper.id.png" alt="Profile Picture">
                </div>
                <div class="info-section">
                    <p class="profile-name"><?= $_SESSION['name']; ?></p>
                    <p class="profile-tagline"><?= $companyData['about']; ?></p>
                    <p class="profile-location"><?= $companyData['lokasi']; ?> •</p>
                </div>
            </div>
        </div>
    </section>
    <section class="jobvacancy-company">
        <div class="jobvacancy-container">
            <h5>Job Vacancy</h5>
            <div id="jobvacancy-cards">
                <?php foreach ($companyJobs as $item): ?>
                    <div class="jobvacancy-card">
<!--                        <img src="--><?php //= $item['image']; ?><!--" alt="--><?php //= $item['posisi']; ?><!--">-->
                        <img src="../public/images/paper.id.png" alt="<?= $item['posisi']; ?>">
                        <div class="jobvacancy-info">
                            <a href="#"><?= $item['posisi']; ?></a>
                            <p><?= $item['deskripsi']; ?></p>
                            <p><?= $item['jenis_pekerjaan']; ?><span> • <?= $item['jenis_lokasi']; ?></span></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
</body>
</html>
