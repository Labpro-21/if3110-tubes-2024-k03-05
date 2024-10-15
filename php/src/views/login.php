<?php include ("/php/src/public/CSS/login.css");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        // <link  rel="stylesheet" href="login.css">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="container" id="signin">
            <div class="box form-box">

                <header>
                    Sign in
                </header>

                <p>Stay updated on your professional world.</p>
        
                <form action="" method="post"> <!-- post adalah metode yang didukung oleh HTTP dan menggambarkan bahwa server web menerima data yang disertakan dalam input -->
                    <div class="input-group">
                        <input type="text" name="EmailorPhone" id="emailOrPhone" placeholder="Email or Phone" required>
                        <label for="emailOrPhone">Email or Phone</label>
                    </div>
                    <div class="input-group">
                        <input type="text" name="Password" id="password" placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>
                    <p class="forget">
                        <a href="">
                            Forget Password?
                        </a>
                    </p>
                    <input type="submit" class="btn" value= "Sign In" name="Sign In">
                </form>
                
                <p Class="or">
                    -------------or--------------
                </p>
                <div class="links">
                    New to LinkinPurry? 
                    <a href="">Join Now</a>
                </div>
            </div>
        </div>
    </body>
</html>
