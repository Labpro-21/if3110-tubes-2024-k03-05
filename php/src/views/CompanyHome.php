<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Homepage</title>
    <link rel="stylesheet" type="text/css" href="../public/CSS/global.css">
    <link rel="stylesheet" type="text/css" href="../public/CSS/CompanyHome.css">
</head>
<body>
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
                <p class="user-location"><?= $details['location']?></p>
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
                        Filter by
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                             style="transform: translate(3px, 3px);" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m7 10l5 5l5-5z"/>
                        </svg>
                    </button>
                    <div class="dropdown-content">
                        <a href="#" data-id="All">All</a>
                        <a href="#" data-id="Full-time">Full-time</a>
                        <a href="#" data-id="Part-time">Part-time</a>
                        <a href="#" data-id="Internship">Internship</a>
                    </div>
                </div>

                <button class="sortby-btn">Sort by Date</button>
            </div>
        </section>

        <section class="feed-post">
            <div class="jobvacancy-container">
                <div class="wrapper">
                    <p class="all">All posted Job</p>
                    <a href="/tambahLowongan">
                        Add job
                    </a>
                </div>
                
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
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <button onclick="updatePageInUrl(<?= $i; ?>)" class="<?= $i === $page ? 'active' : ''; ?>"><?= $i; ?></button>
                    <?php endfor; ?>
                </div>
            </div>
        </section>
    </main>
</div>


<script src="../public/JS/filterBtnHomepage.js"></script>
<script src="../public/JS/sortbyBtnHomepage.js"></script>
<script src="../public/JS/pagination.js"></script>
</body>
</html>
