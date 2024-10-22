<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lamaran</title>
    <link rel="stylesheet" type="text/css" href="../public/CSS/detailLamaran.css">
</head>
<body>
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
                        <?= $lamaran['status-reason'] ?>
                    </p>
                </div>
            </div>
            <div class="btn-group">
                <button class="btn-approve" onclick="updateStatus('accepted')">Approve</button>
                <button class="btn-reject" onclick="toggleReasonInput()">Reject</button>
                <div class="form-group" id="reasonForm" style="display:none;">
                    <textarea id="reasonInput" placeholder="Berikan alasan/tindak lanjut..." ></textarea>
                    <button onclick="updateStatus('rejected')">Submit</button>
                </div>
            </div>
        </section>
    </div>

    <!-- Main Content -->
    <div class="resume-video">
        <section>
            <p>Applicant's Resume</p>
            <iframe src="<?= htmlspecialchars($lamaran['cv_path'], ENT_QUOTES, 'UTF-8'); ?>" width="100%" height="600px"></iframe
        </section>

        <section>
            <p>Applicant's Video</p>
            <video width="100%" height="400" controls>
                <source src="<?= htmlspecialchars($lamaran['video_path'], ENT_QUOTES, 'UTF-8'); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </section>
    </div>
</div>


<script src="../public/JS/detailLamaran.js"></script>
<script>
    updateStatus('<?= $lamaran['status'] ?>');
</script>
</body>
</html>