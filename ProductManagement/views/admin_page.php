<?php
session_start();

// Check if the user is logged in and is a store manager
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'store_manager') {
    header("Location: login.php");
    exit();
}

include '../connection.php';
include '../controller/nav.php';


// Fetch all products from the database
$sql = "SELECT * FROM products WHERE is_deleted = 0";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../css/main.css">   
        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/main.js" defer></script>
</head>
<body>

    
    <div class="container">
        <h1>Admin Panel</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Image</th>
                    <th>SKU</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['ProductName'] . "</td>";
                        echo "<td><img src='" . $row['ProductImage'] . "' alt='" . $row['ProductName'] . "' width='50'></td>";
                        echo "<td>" . $row['ProductSKU'] . "</td>";
                        echo "<td>
                                <a href='edit_product.php?id=" . $row['ProductID'] . "' class='btn btn-primary btn-sm'>Edit</a> |
                                <a href='../controller/delete_product.php?id=" . $row['ProductID'] . "' class='btn btn-primary btn-sm'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No products found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <br>
        <a href="add_product.php" class="btn">Add New Product</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        
</body>
</html>

<?php
mysqli_close($conn);
?>
