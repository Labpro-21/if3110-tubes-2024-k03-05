<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/CSS/login.css">
</head>
<body>
<div class="container" id="signin">
    <div class="box form-box">
        <header>
            Sign in
        </header>

        <p>Stay updated on your professional world.</p>

        <form >
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
                <span id="togglePassword" onclick="togglePassword('password', 'togglePassword')">`</span>
            </div>
            <input type="submit" class="btn" value="Sign in" name="Sign In">
        </form>
    </div>
    <div id="toast" class="toast"></div>
</div>
<div class="register">
    <div class="links">
        New to LinkInPurry?
        <a href="/register">Join Now</a>
    </div>
</div>
<script src="../public/JS/Login.js"></script>
</body>
</html>