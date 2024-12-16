<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'store_manager') {
    header("Location: login.php");
    exit();
}

include '../connection.php';



// Fetch categories and brands for the select options
$categories = mysqli_query($conn, "SELECT * FROM categories");
$brands = mysqli_query($conn, "SELECT * FROM brands");

if (isset($_POST['add'])) {
    $product_name = $_POST['ProductName'];
    $sku = $_POST['ProductSKU'];
    $category_ids = isset($_POST['category']) ? $_POST['category'] : [];
    $brand_ids = isset($_POST['brand']) ? $_POST['brand'] : [];
    $price = $_POST['price'];

    // Handle file upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["ProductImage"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["ProductImage"]["tmp_name"], $target_file);

    // Validate SKU uniqueness
    $check_sku = mysqli_query($conn, "SELECT * FROM products WHERE ProductSKU='$sku'");
    if (mysqli_num_rows($check_sku) > 0) {
        echo "SKU already exists.";
    } else {
        // Insert product
        $sql = "INSERT INTO products (ProductName, ProductSKU, ProductImage, ProductPrice) 
                VALUES ('$product_name', '$sku', '$target_file', '$price')";
        if (mysqli_query($conn, $sql)) {
            $product_id = mysqli_insert_id($conn);

            // Link categories to the product
            foreach ($category_ids as $category_id) {
                $sql_category = "INSERT INTO productcategories (ProductID, CategoryID) 
                                 VALUES ('$product_id', '$category_id')";
                mysqli_query($conn, $sql_category);
            }

            // Link brands to the product
            foreach ($brand_ids as $brand_id) {
                $sql_brand = "INSERT INTO productbrands (ProductID, BrandID) 
                              VALUES ('$product_id', '$brand_id')";
                mysqli_query($conn, $sql_brand);
            }

            header("Location: ../views/admin_page.php");
        } else {
            echo "Error adding product: " . mysqli_error($conn);
        }
    }
}
?>