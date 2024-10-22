<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../public/CSS/LandingPage.css">
</head>
<body>
<div class="container">
    <div class="content">
        <h1>Daftar gratis dan dapatkan pekerjaan yang tepat untukmu</h1>
        <button class="btn-google" onclick={onLoginClick()}>Login</button>
        <p class="agreement">
            Dengan mengklik Lanjutkan untuk bergabung atau login, Anda menyetujui
            <a href="#">Perjanjian Pengguna</a>, <a href="#">Kebijakan Privasi</a>, dan <a href="#">Kebijakan Cookie</a> PurrIn.
        </p>
        <p>Baru mengenal PurrIn? <a href="/register">Bergabung sekarang</a></p>
    </div>
    <div class="image-section">
        <img src="../public/images/LandingPage.jpg" alt="Two people working" />
    </div>
</div>
<script src="../public/JS/LandingPage.js"></script>
</body>
</html>
