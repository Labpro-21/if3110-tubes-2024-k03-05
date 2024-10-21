<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lowongan</title>
    <link rel="stylesheet" href="../public/CSS/tambahLowongan.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>
    <div class="container" id="signin">
        <div class="box form-box">
            <header>Add Job Vacancy</header>
            <div class="divider"></div>
            <form action="/tambahLowongan" method="post">
                <div class="input-group">
                    <label for="position">Position</label>
                    <input type="text" name="Position" id="position" placeholder="Enter Position" required>
                </div>
                <div class="input-group">
                    <p>Description</p>
                    <div id="editor"></div>
                    <input type="hidden" name="description" id="descriptionInput" required>
                </div>
                <div class="input-group">
                    <label for="type">Type</label>
                    <select name="Type" id="type" required>
                        <option value="" disabled selected>Select Type</option>
                        <option value="internship">Internship</option>
                        <option value="part-time">Part-time</option>
                        <option value="full-time">Full-time</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="work">Work Location</label>
                    <select name="Work" id="work" required>
                        <option value="" disabled selected>Select Work Location</option>
                        <option value="on-site">On-Site</option>
                        <option value="remote">Remote</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>
                <div class="add-button">
                    <input type="submit" class="btn" value="Add" name="Add">
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="../public/JS/TambahLowongan.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
</body>
</html>