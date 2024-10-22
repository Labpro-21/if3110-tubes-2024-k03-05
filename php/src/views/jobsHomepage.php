<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs Homepage</title>
    <link rel="stylesheet" href="../public/CSS/jobsHomepage.css">
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="profile-card">
                <img src="/public/images/linkedinbanner.jpg" class="banner" alt="Banner">
                <div class="avatar">
                    <img src="/public/images/profile-img.jpg" alt="Profile Picture">
                </div>
                <div class="info-section">
                    <p class="user-name">John Doe</p>
                    <p class="user-desc">Undergraduate Student of Informatics Engineering at ITB</p>
                    <p class="user-location">Jakarta</p>
                </div>
            </div>
        </div>

        <main class="job">
            <section class="job-box">
                <p>Find Job</p>
                <div class="job-options">
                    <div class="dropdown">
                        <button class="dropdown-btn">Filter Job Type</button>
                        <div class="dropdown-content">
                            <a href="#" data-id="All">All</a>
                            <a href="#" data-id="Full-time">Full-time</a>
                            <a href="#" data-id="Part-time">Part-time</a>
                            <a href="#" data-id="Internship">Internship</a>
                        </div>
                    </div>
                    <div class="dropdownLoc">
                        <button class="dropdownLoc-btn">Filter Location Type</button>
                        <div class="dropdownLoc-content">
                            <a href="#" data-id="All">All</a>
                            <a href="#" data-id="On-site">On-site</a>
                            <a href="#" data-id="Remote">Remote</a>
                            <a href="#" data-id="Hybrid">Hybrid</a>
                        </div>
                    </div>
                    <div class="sortBy">
                        <button class="sortBy-btn">Sort by Date</button>
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
                        <?php foreach ($parsedJobs as $item): ?>
                            <div class="job-card">
    <!--                            <img src="--><?php //= htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8') ?><!--" alt="--><?php //= htmlspecialchars($item['posisi'], ENT_QUOTES, 'UTF-8') ?><!--">-->
                                <div class="jobvacancy-info">
                                    <div class="job-name-date">
                                        <a href="/detailLowongan<?= $item['lowongan_id']?>"><?= htmlspecialchars($item['posisi'], ENT_QUOTES, 'UTF-8') ?></a>
                                        <span><?= date('F j, Y', strtotime($item['created_at'])) ?></span>
                                    </div>
                                    <p><?= htmlspecialchars($item['deskripsi'], ENT_QUOTES, 'UTF-8') ?></p>
                                    <p><?= htmlspecialchars($item['jenis_pekerjaan'], ENT_QUOTES, 'UTF-8') ?> <span>•</span> <?= htmlspecialchars($item['jenis_lokasi'], ENT_QUOTES, 'UTF-8') ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pagination">
                        <?php
                        $maxPagesToShow = 5; // Number of pages to show around the current page
                        $halfPagesToShow = floor($maxPagesToShow / 2);

                        // Adjust the start and end pages based on the current page
                        $startPage = max(1, $page - $halfPagesToShow);
                        $endPage = min($totalPages, $page + $halfPagesToShow);

                        // Ensure the total number of pages displayed remains consistent
                        if ($page <= $halfPagesToShow) {
                            $endPage = min($totalPages, $maxPagesToShow);
                        } elseif ($page > $totalPages - $halfPagesToShow) {
                            $startPage = max(1, $totalPages - $maxPagesToShow + 1);
                        }

                        // Display "Previous" button if not on the first page
                        if ($page > 1) {
                            echo '<button onclick="updatePageInUrl(' . ($page - 1) . ')">Previous</button>';
                        }

                        // Display "First" page button if not within the visible range
                        if ($startPage > 1) {
                            echo '<button onclick="updatePageInUrl(1)">1</button>';
                            if ($startPage > 2) {
                                echo '<span>...</span>'; // Ellipsis for skipped pages
                            }
                        }

                        // Loop through the visible pagination range
                        for ($i = $startPage; $i <= $endPage; $i++) {
                            echo '<button onclick="updatePageInUrl(' . $i . ')" class="' . ($i === $page ? 'active' : '') . '">' . $i . '</button>';
                        }

                        // Display "Last" page button if not within the visible range
                        if ($endPage < $totalPages) {
                            if ($endPage < $totalPages - 1) {
                                echo '<span>...</span>'; // Ellipsis for skipped pages
                            }
                            echo '<button onclick="updatePageInUrl(' . $totalPages . ')">' . $totalPages . '</button>';
                        }

                        // Display "Next" button if not on the last page
                        if ($page < $totalPages) {
                            echo '<button onclick="updatePageInUrl(' . ($page + 1) . ')">Next</button>';
                        }
                        ?>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="../public/JS/jobVacancyPagination.js"></script>
    <script src="../public/JS/filterBtnHomepage.js"></script>
    <script src="../public/JS/sortbyBtnHomepage.js"></script>
    <script src="../public/JS/pagination.js"></script>
</body>
</html>