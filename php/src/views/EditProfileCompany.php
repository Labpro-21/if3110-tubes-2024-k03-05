<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile Company</title>
    <link rel="stylesheet" href="../public/CSS/editProfileCompany.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>
    <main class="form-container">
        <div class="title">
            <h1>Edit Profile Company</h1>
            <a href="/profileCompany" class="btn-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M20 20L4 4m16 0L4 20"/></svg>
            </a>
        </div>
        <form action="/editProfileCompany?userId=<?= $userId ?>" id="applicantForm" method="post">
            <div class="input-group">
                <label for="name">Company Name</label>
                <input type="text" id="name" name="name" placeholder="Enter new company name" value="<?= $companyData['nama'] ?>" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter new company email" value="<?= $companyData['email'] ?>" required>
            </div>

            <div class="input-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" id="location" name="location" placeholder="Enter new company location" value="<?= $companyData['lokasi'] ?>" required>
            </div>

            <div class="input-group">
                <p>About the company</p>
                <div id="editor"><?= $companyData['about'] ?></div>
                <input type="hidden" name="about" id="aboutInput" 
                    value="<?= $companyData['about'] ?>" required>
            </div>

            <div class="add-button">
                <input type="submit" class="btn" value="Save" name="Save">
            </div>
        </form>
        <div id="response"></div>
    </main>
    
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="../public/JS/EditProfileCompany.js"></script>
  
</body>
</html>