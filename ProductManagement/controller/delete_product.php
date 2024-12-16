<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'store_manager') {
    header("Location: login.php");
    exit();
}

include '../connection.php';

$product_id = $_GET['id'];


$sql_update_product = "UPDATE products SET is_deleted = 1 WHERE ProductID='$product_id'";

if (mysqli_query($conn, $sql_update_product)) {
    header("Location: ../views/admin_page.php");
} else {
    echo "Error updating product: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
