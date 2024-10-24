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
            <ul class="filter-buttons">
                <li><button class="active" onclick="setActiveButton('all')">All</button></li>
                <li><button onclick="setActiveButton('waiting')">Waiting</button></li>
                <li><button onclick="setActiveButton('accept')">Accept</button></li>
                <li><button onclick="setActiveButton('reject')">Reject</button></li>
            </ul>
            <hr>
            <div class="no-jobs">
                <img src="../public/images/image.png" alt="No Jobs Image">
                <h2>No recent job activity</h2>
                <p>Find new opportunities and manage your job search progress here.</p>
                <button onclick="window.location.href='/dashboard'">Search for jobs</button>
            </div>
        </div>
    </main>
    <script src="../public/JS/RiwayatEmpty.js"></script>
</body>
</html>
