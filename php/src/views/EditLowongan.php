<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lowongan</title>
    <link rel="stylesheet" href="../public/CSS/editLowongan.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/CSS/companyHomepageNavbar.css">
</head>

<body>
    <?php include 'companyNavbar.php'; ?>
    <div class="container" id="signin">
        <div class="box form-box">
            <header>Edit Job Vacancy</header>
            <div class="divider"></div>
            <form id="jobForm">

                <input type="hidden" name="lowonganId" value="<?= $jobData['lowongan_id'] ?>">

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

                <hr>
                <div class="current">
                    <label for="attachment">Current Attachment</label>
                    <div id="attachment-container">
                        <?php foreach ($attachments as $attachment) : ?>
                        <div class="attachment">
                            <p for="Attachment">File Name: <?= $attachment['name'] ?></p>
                            <div class ="att-img">
                                <!-- <input type="text" name="<?= $attachment['attachment_id']?>" value="<?= $attachment['name'] ?>" readonly> -->
                                <img src="<?= $attachment['url']?>" alt="Attachment" class="attachment-image">
                            </div>
                            <button name="<?= $attachment['attachment_id']?>" value="<?= $attachment['name'] ?>" type="button" class="remove-attachment">Remove</button>
                        </div>
                        <hr>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="new">
                    <label for="Attachment">New Attachment</label>
                    <input type="file" name="Attachment[]" id="Attachment" accept="image/*" multiple>
                    <input type="hidden" name="AttachmentCount" id="AttachmentCount" value=0>
                </div>

                <div class="add-button">
                    <input type="submit" class="btn">
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="../public/JS/EditLowongan.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

</body>

</html>