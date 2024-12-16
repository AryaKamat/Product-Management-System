<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit();
}

$id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    echo "User not found!";
    exit();
}

// Set profile picture with fallback to default
$profile_picture = !empty($user['profile_picture']) ? "../uploads/" . $user['profile_picture'] : "../uploads/default.png";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $dob = htmlspecialchars($_POST['dob']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Update profile picture if new one is uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = basename($_FILES["profile_picture"]["name"]);
        }
    }

    // Prepare update query based on whether password is provided
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', dob = '$dob', email = '$email', password = '$hashed_password', profile_picture = '$profile_picture' WHERE id = $id";
    } else {
        $update_query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', dob = '$dob', email = '$email', profile_picture = '$profile_picture' WHERE id = $id";
    }

    if (mysqli_query($conn, $update_query)) {
        echo "Profile updated successfully!";
        header("Location: ../views/profile.php");
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
