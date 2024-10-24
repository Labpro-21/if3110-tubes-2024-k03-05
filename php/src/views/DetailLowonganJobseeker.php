<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan</title>
    <link rel="stylesheet" href="../public/CSS/DetailLowonganJobseeker.css">
    <link rel="stylesheet" href="../public/CSS/jobsHomepageNavbar.css">
</head>
<body>
<?php include 'jobsNavbar.php'; ?>
<main>
    <div class="container">
        <!-- Name Card -->
        <div class="name-card box">
            <header>
                <p><?=job['nama']?></p>
            </header>
            <h1><?= $job['posisi']?></h1>
            <div class="detail">
                <p>Location</p>
                <span class="dot"></span>
                <p>1 days ago</p>
                <span class="dot"></span>
                <p><?= $totalApplicants?> applicants</p>
            </div>
            <div class="keterangan">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48"><g fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M14 14a6 6 0 0 1 6-6h9a6 6 0 0 1 6 6v2H14z"/><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="m4 25l19.515 4.879c.318.08.652.08.97 0L44 25v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M44 27v-9a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9"/><path fill="currentColor" d="M26.5 23a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0"/></g></svg>
                <p><?= $job['jenis_lokasi'] ?></p>
                <span class="dot"></span>
                <p><?= $job['jenis_pekerjaan'] ?></p>
            </div>
        </div>

        <!-- Description -->
        <div class="description box">
            <h2>Description</h2>
            <p>
                <?= $job['deskripsi'] ?>
            </p>
        </div>


        <div class="end">
            <button class="close">Apply</button>
        </div>
    </div>
</main>
</body>
</html>
<?php
