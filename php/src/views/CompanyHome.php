<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Homepage</title>
    <link rel="stylesheet" href="../public/CSS/CompanyHome.css">
    <link rel="stylesheet" href="../public/CSS/companyHomepageNavbar.css">
</head>

<body>
<?php include 'companyHomepageNavbar.php'; ?>
<div class="container">
    <!-- Sidebar Profile -->
    <div class="sidebar">
        <div class="profile-card">
            <img src="../public/images/linkedinbanner.jpg" class="banner" alt="Banner">
            <div class="avatar">
                <img src="../public/images/profile-img.jpg" alt="Profile Picture">
            </div>
            <div class="info-section">
                <p class="user-name"><?= $details['name']?></p>
                <p class="user-desc"><?= $details['about']?></p>
                <p class="user-location"><svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24"><path fill="currentColor" d="M19 9A7 7 0 1 0 5 9c0 1.387.409 2.677 1.105 3.765h-.008L12 22l5.903-9.235h-.007A6.97 6.97 0 0 0 19 9m-7 3a3 3 0 1 1 0-6a3 3 0 0 1 0 6"/></svg>
                    <?=$details['location']?>
                </p>
            </div>
        </div>

    </div>

    <!-- Main Content -->
    <main class="job">
        <section class="job-box">
            <p>Find Job</p>
            <div class="job-options">
                <div class="dropdown">
                    <button class="dropdown-btn">
                        Filter Job Type
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                            style="transform: translate(3px, 3px);" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m7 10l5 5l5-5z"/>
                        </svg>
                    </button>
                    <div class="dropdownLoc-content">
                            <a href="#" data-id="All">All</a>
                            <a href="#" data-id="On-site">On-site</a>
                            <a href="#" data-id="Remote">Remote</a>
                            <a href="#" data-id="Hybrid">Hybrid</a>
                    </div>
                </div>
                <div class="dropdownLoc">
                    <button class="dropdownLoc-btn">
                        Filter Location Type
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                            style="transform: translate(3px, 3px);" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m7 10l5 5l5-5z"/>
                        </svg>
                    </button>
                    <div class="dropdownLoc-content">
                            <a href="#" data-id="All">All</a>
                            <a href="#" data-id="On-site">On-site</a>
                            <a href="#" data-id="Remote">Remote</a>
                            <a href="#" data-id="Hybrid">Hybrid</a>
                    </div>
                </div>
                <div class="sortBy">
                    <button class="sortBy-btn">
                        Sort by Date
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                            style="transform: translate(3px, 3px);" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m7 10l5 5l5-5z"/>
                        </svg>
                    </button>
                    <div class="sortBy-content">
                        <a href="#" data-id="Ascending">Ascending</a>
                        <a href="#" data-id="Descending">Descending</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="feed-post">
            <div class="jobvacancy-container">
                <p>Available Job Vacancies</p>
                <div id="jobvacancy-cards">
                </div>

                <div class="pagination">

                </div>
            </div>
        </section>
    </main>
</div>


<script src="../public/JS/HomepageComp.js"></script>
<script src="../public/JS/sortbyBtnHomepage.js"></script>
<script src="../public/JS/filterBtnHomepage.js"></script>
<script>
        fetchJobs(new URLSearchParams());
</script>
</body>
</html>
