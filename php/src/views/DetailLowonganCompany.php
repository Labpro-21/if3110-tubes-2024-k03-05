<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan</title>
    <link rel="stylesheet" href="../public/CSS/detailLowonganCompany.css">
</head>
<body>
<main>
        <div class="container">
            <!-- Name Card -->
            <div class="name-card box">
                <header>
                    <a href="/profileCompany?user_id=<?= $jobData['user_id'] ?>"><?= $jobData['nama'] ?></a>
                </header>
                <h1><?= $jobData['posisi']?></h1>
                <div class="detail">
                    <p><?= $jobData['lokasi'] ?></p>
                    <span class="dot"></span>
                    <p><?= $daysAgo ?> days ago</p>
                    <span class="dot"></span>
                    <p><?= $totalApplicants ?> applicants</p>
                </div>
                <div class="keterangan">
                    <p><?= $jobData['jenis_lokasi'] ?></p>
                    <span class="dot"></span>
                    <p><?= $jobData['jenis_pekerjaan'] ?></p>
                </div>
                <div class="buttons">
                    <a href="/editLowongan?lowongan_id=<?= $lowonganId ?>" class="button-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                            <path fill="currentColor" d="M13.5 0a2.5 2.5 0 0 1 2 4l-1 1L11 1.5l1-1c.418-.314.937-.5 1.5-.5M1 11.5L0 16l4.5-1l9.25-9.25l-3.5-3.5zm10.181-5.819l-7 7l-.862-.862l7-7z"/>
                        </svg>
                        
                    </a>
                    <a href="#" class="button-wrapper delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Description -->
            <div class="description box">
                <h2>Description</h2>
                <div><?= htmlspecialchars_decode($jobData['deskripsi']) ?></div>
            </div>

            <!-- Applicants -->
            <div class="applicants box">
                <h2>Applicants</h2>
                <?php foreach ($applicants as $applicant): ?>
                    <div class="applicant-card">
                        <a href="/detailLamaran?lamaran_id=<?= $applicant['lamaran_id'] ?>" class="name"><?= $applicant['nama'] ?></a>
                        <p class="status"><?= $applicant['status'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="end">
                <button class="close">Close Recruitment</button>
            </div>
        </div>
    </main>
</body>
</html>