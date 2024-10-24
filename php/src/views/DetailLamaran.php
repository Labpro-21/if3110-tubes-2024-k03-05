<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lamaran</title>
    <link rel="stylesheet" type="text/css" href="../public/CSS/detailLamaran.css">
    <link rel="stylesheet" type="text/css" href="../public/CSS/companyNavbar.css">
</head>
<body>
<?php
include __DIR__ . '/../views/companyNavbar.php';
?>
<div class="container">
    <!-- Sidebar Profile -->
    <div class="detail-status">
        <section class="applicant-details">
            <p>Applicants Details</p>
            <p>Nama<br><span class="pelamar-name"><?= $lamaran['nama'] ?></span></p>
            <p>Lamaran<br><span class="pelamar-email"><?= $lamaran['email']?></span></p>
        </section>
        <section>
            <p>Status</p>
            <div>
                <p class="status waiting" id="statusText"><?= $lamaran['status'] ?></p>
                <div id="followUpReason" style="display:none;">
                    <p id="reasonText">
                        <?= $lamaran['status_reason'] ?>
                    </p>
                </div>
            </div>
            <?php
            if ($lamaran['status'] === 'waiting') {
                ?>
                <div class="btn-group">
                    <button class="btn-approve" onclick="toggleReasonInput()">Approve</button>
                    <button class="btn-reject" onclick="toggleReasonInput()">Reject</button>
                    <div class="form-group" id="reasonForm" style="display:none;">
                        <textarea id="reasonInput" placeholder="Berikan alasan/tindak lanjut..." ></textarea>
                        <button onclick={submitReason('accepted')}>Submit</button>
                    </div>
                    <div class="form-group" id="reasonForm" style="display:none;">
                        <textarea id="reasonInput" placeholder="Berikan alasan/tindak lanjut..." ></textarea>
                        <button onclick={submitReason('rejected')}>Submit</button>
                    </div>
                </div>
            <?php
            }
            ?>
        </section>
    </div>

    <!-- Main Content -->
    <div class="resume-video">
        <section>
            <p>Applicant's Resume</p>
            <iframe src="/serveFile?file=<?= urlencode($lamaran['cv_path']); ?>" width="100%" height="600px"></iframe>
        </section>

        <section>
            <p>Applicant's Video</p>
            <video width="100%" height="400" controls>
                <source src="/serveFile?file=<?= urlencode($lamaran['video_path']); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </section>
    </div>
</div>
<div id="toast" class="toast"></div>


<script src="../public/JS/detailLamaran.js"></script>
<script>
    updateStatus('<?= $lamaran['status'] ?>');
</script>
</body>
</html>