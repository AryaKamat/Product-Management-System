<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../connection.php'; // Include the database connection

if(isset($_POST['register']))
{
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpass'];
    $profilePicture = $_FILES['profile_picture'];

    // Backend DOB validation
    $dobDate = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($dobDate)->y;

    if ($age < 18) {
        $_SESSION['status'] = "You must be at least 18 years old to sign up.";
        header("Location: ../views/register.php");
        exit(0);
    }

    // Check if the email already exists
    $check = "SELECT * FROM users WHERE email='{$email}'";
    $res = mysqli_query($conn, $check);
    $passwd = password_hash($pass, PASSWORD_DEFAULT);

    if (mysqli_num_rows($res) > 0) {
        $_SESSION['status'] = "This email is used, try another one.";
        header("Location: ../views/register.php");
        exit(0);
    }

    if ($pass !== $cpass) {
        $_SESSION['status'] = "Password does not match.";
        header("Location: ../views/register.php");
        exit(0);
    }

    // Check if the profile picture size is greater than 1 MB
    if ($profilePicture['size'] <= 1048576) {
        $_SESSION['status'] = "Profile picture must be greater than 1 MB.";
        header("Location: ../views/register.php");
        exit(0);
    }

    $sql = "INSERT INTO users (firstname, lastname, dob, email, password) VALUES ('$firstName', '$lastName', '$dob', '$email', '$passwd')";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $_SESSION['status'] = "Registration failed, try again.";
        header("Location: ../views/register.php");
        exit(0);
    }

    // Upload profile picture
    $targetDir = "../uploads/";
    $profilePictureName = basename($profilePicture['name']);
    $targetFile = $targetDir . $profilePictureName;
    move_uploaded_file($profilePicture['tmp_name'], $targetFile);

    // Update user table with profile picture
    $updateQuery = "UPDATE users SET profile_picture = '$profilePictureName' WHERE email = '$email'";
    mysqli_query($conn, $updateQuery);

    // Create an instance; passing true enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->Username   = 'arya.kamat@kilowott.com';                     //SMTP username
        $mail->Password   = 'wgowomfoedotrlmu';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

        //Recipients
        $mail->setFrom('arya.kamat@kilowott.com', 'Wanderes Unite');
        $mail->addAddress($email, $firstName);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Successfull Registeration';
        $mail->Body    = '<h3>Hello, You have succcessfully registered.</h3>';

        if ($mail->send()) {
            $_SESSION['status'] = "You are registered successfully! A confirmation email has been sent.";
            header("Location: ../views/register.php");
            exit(0);
        } else {
            $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header("Location: ../views/register.php");
            exit(0);
        }
    } catch (Exception $e) {
        $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        header("Location: ../views/register.php");
        exit(0);
    }
} else {
    header('Location: ../views/register.php');
    exit(0);
}
?>
