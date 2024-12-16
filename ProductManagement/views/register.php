<?php
session_start();

include '../controller/nav.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="../css/main.css" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="../js/validation.js"></script>
</head>

<body>
  <div class="container">
    <div class="form-box box">

      <?php
      if (isset($_SESSION['status'])) {
        echo "<div class='message'><p>{$_SESSION['status']}</p></div><br>";
        unset($_SESSION['status']);
      }
      ?>

      <header>Sign Up</header>
      <form name="signupForm" action="../controller/sendmail.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="form-box">
          <div class="input-container">
            <i class="fa fa-user icon"></i>
            <input class="input-field" type="text" placeholder="First Name" name="firstname" required>
          </div>
          <div class="input-container">
            <i class="fa fa-user icon"></i>
            <input class="input-field" type="text" placeholder="Last Name" name="lastname" required>
          </div>
          <div class="input-container">
            <i class="fa fa-calendar icon"></i>
            <input class="input-field" type="date" id="dob" placeholder="Date of Birth" name="dob" required>
          </div>
          <div class="input-container">
            <i class="fa fa-envelope icon"></i>
            <input class="input-field" type="email" placeholder="Email Address" name="email" required>
          </div>
          <div class="input-container">
            <i class="fa fa-lock icon"></i>
            <input class="input-field password" type="password" placeholder="Password" name="password" required>
            <i class="fa fa-eye icon toggle"></i>
          </div>
          <div class="input-container">
            <i class="fa fa-lock icon"></i>
            <input class="input-field" type="password" placeholder="Confirm Password" name="cpass" required>
            <i class="fa fa-eye icon"></i>
          </div>
          <div class="input-container">
            <i class="fa fa-camera icon"></i>
            <input class="input-field" type="file" name="profile_picture" required>
          </div>
        </div>
        <center><input type="submit" name="register" id="submit" value="Signup" class="btn"></center>
        <div class="links">
          Already have an account? <a href="login.php">Login Now</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
