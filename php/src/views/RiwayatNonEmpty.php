<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lamaran</title>
    <link rel="stylesheet" href="../public/CSS/riwayatNonEmpty.css">
    <link rel="stylesheet" href="../public/CSS/jobsHomepageNavbar.css">
</head>
<body>
    <?php include 'jobsNavbar.php'; ?>
    <main>
    <div class="container">
            <header>My Jobs</header>
            
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
            </form>
            <hr>

            <?php foreach ($jobs as $job): ?>
            <div class="job-card">
                <a href="" class="Position"><?= $job['posisi'] ?></a>
                <p class="perusahaan"><?= $job['nama'] ?></p>
                <div class="dot-elmt">
                    <p class="location"><?= $job['lokasi']?></p>
                    <span class="dot"></span>
                    <p>applied at <?= date('Y-m-d', strtotime($job['created_at'])) ?></p>
                </div>
                <p class="status"><?= $job['status'] ?></p>
            </div>
            <hr>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
