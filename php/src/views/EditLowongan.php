<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lowongan</title>
    <link rel="stylesheet" href="../public/CSS/editLowongan.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
    <div class="container" id="signin">
        <div class="box form-box">
            <header>Edit Job Vacancy</header>
            <div class="divider"></div>
            <form action="/editLowongan?lowonganId=<?= $lowonganId ?>" method="post">
                <div class="input-group">
                    <label for="position">Position</label>
                    <input type="text" name="Position" id="position" placeholder="Enter Position"
                        value="<?= $jobData['posisi'] ?>" required>
                </div>
                <div class="input-group">
                    <p>Description</p>
                    <div id="editor"><?= $jobData['description'] ?></div>
                    <input type="hidden" name="description" id="descriptionInput"
                        value="<?= $jobData['deskripsi'] ?>" required>
                </div>
                <div class="input-group">
                    <label for="type">Type</label>
                    <select name="Type" id="type" required>
                        <option value="" disabled>Select Type</option>
                        <option value="internship" <?= isset($jobData['type']) && $jobData['type'] === 'internship' ? 'selected' : '' ?>>Internship</option>
                        <option value="part-time" <?= isset($jobData['type']) && $jobData['type'] === 'part-time' ? 'selected' : '' ?>>Part-time</option>
                        <option value="full-time" <?= isset($jobData['type']) && $jobData['type'] === 'full-time' ? 'selected' : '' ?>>Full-time</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="work">Work Location</label>
                    <select name="Work" id="work" required>
                        <option value="" disabled>Select Work Location</option>
                        <option value="on-site" <?= isset($jobData['work_location']) && $jobData['work_location'] === 'on-site' ? 'selected' : '' ?>>On-Site</option>
                        <option value="remote" <?= isset($jobData['work_location']) && $jobData['work_location'] === 'remote' ? 'selected' : '' ?>>Remote</option>
                        <option value="hybrid" <?= isset($jobData['work_location']) && $jobData['work_location'] === 'hybrid' ? 'selected' : '' ?>>Hybrid</option>
                    </select>
                </div>

                <div class="add-button">
                    <input type="submit" class="btn" value="Save" name="Save">
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="../public/JS/EditLowongan.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

</body>

</html>