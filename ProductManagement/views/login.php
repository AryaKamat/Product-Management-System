<?php


include '../controller/log.php';
include '../controller/nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../js/loginvalidation.js"></script>
</head>
<body>
<div class="container">
    <div class="form-box box">
    
        <header>Login</header>
        <hr>
        <form name="loginForm" action="" method="POST" onsubmit="return validateLoginForm();">
            <div class="form-box">
                <div class="input-container">
                    <i class="fa fa-envelope icon"></i>
                    <input class="input-field" type="email" placeholder="Email Address" name="email">
                </div>
  
                <div class="input-container">
                    <i class="fa fa-lock icon"></i>
                    <input class="input-field password" type="password" placeholder="Password" name="password">
                    <i class="fa fa-eye toggle icon"></i>
                </div>
            </div>
            <input type="submit" name="login" id="submit" value="Login" class="btn">

            <div class="links">
                Don't have an account? <a href="register.php">Signup Now</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
