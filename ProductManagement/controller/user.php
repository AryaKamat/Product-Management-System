<?php



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
?>