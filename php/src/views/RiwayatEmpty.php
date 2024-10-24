<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lamaran Kosong</title>
    <link rel="stylesheet" href="../public/CSS/riwayatEmpty.css">
    <link rel="stylesheet" href="../public/CSS/jobsHomepageNavbar.css">
</head>
<body>
<?php include 'jobsNavbar.php'; ?>
<main>
        <div class="container">
            <h1>My Jobs</h1>
            <form method="GET" action="">
                <ul class="filter-buttons">
                    <li>
                        <button type="submit" name="status" value="all" class="<?= (!isset($_GET['status']) || $_GET['status'] === 'all') ? 'active' : '' ?>">All</button>
                    </li>
                    <li>
                        <button type="submit" name="status" value="waiting" class="<?= (isset($_GET['status']) && $_GET['status'] === 'waiting') ? 'active' : '' ?>">Waiting</button>
                    </li>
                    <li>
                        <button type="submit" name="status" value="accepted" class="<?= (isset($_GET['status']) && $_GET['status'] === 'accepted') ? 'active' : '' ?>">Accepted</button>
                    </li>
                    <li>
                        <button type="submit" name="status" value="rejected" class="<?= (isset($_GET['status']) && $_GET['status'] === 'rejected') ? 'active' : '' ?>">Rejected</button>
                    </li>
                </ul>
            <hr>
            </form>
            <div class="no-jobs">
                <img src="../public/images/image.webp" alt="No Jobs Image">
                <h2>No recent job activity</h2>
                <p>Find new opportunities and manage your job search progress here.</p>
                <button onclick="window.location.href='/dashboard'">Search for jobs</button>
            </div>
        </div>
    </main>
    <script src="../public/JS/RiwayatEmpty.js"></script>
</body>
</html>
