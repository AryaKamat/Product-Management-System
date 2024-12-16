<?php
session_start();


// Check if the user is logged in and is a store manager
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'store_manager') {
    header("Location: login.php");
    exit();
}

include '../connection.php';



// Fetch categories and brands for the select options
$categories = mysqli_query($conn, "SELECT * FROM categories");
$brands = mysqli_query($conn, "SELECT * FROM brands");

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the product details
$product_query = "SELECT * FROM products WHERE ProductID = $product_id";
$product_result = mysqli_query($conn, $product_query);

if (mysqli_num_rows($product_result) == 0) {
    echo "Product not found.";
    exit();
}

$product = mysqli_fetch_assoc($product_result);

// Fetch the selected categories and brands for this product
$selected_categories = [];
$selected_brands = [];

$categories_query = "SELECT CategoryID FROM productcategories WHERE ProductID = $product_id";
$categories_result = mysqli_query($conn, $categories_query);
while ($cat = mysqli_fetch_assoc($categories_result)) {
    $selected_categories[] = $cat['CategoryID'];
}

$brands_query = "SELECT BrandID FROM productbrands WHERE ProductID = $product_id";
$brands_result = mysqli_query($conn, $brands_query);
while ($brand = mysqli_fetch_assoc($brands_result)) {
    $selected_brands[] = $brand['BrandID'];
}

if (isset($_POST['update'])) {
    $product_name = $_POST['ProductName'];
    $sku = $_POST['ProductSKU'];
    $price = $_POST['price'];
    $category_ids = isset($_POST['category']) ? $_POST['category'] : []; // IDs from multi-select
    $brand_ids = isset($_POST['brand']) ? $_POST['brand'] : [];

    // Handle image upload
    $product_image = $product['ProductImage']; // Keep existing image by default
    if (!empty($_FILES['ProductImage']['name'])) {
        $target_dir = "../uploads/";
        $file_name = time() . '_' . basename($_FILES["ProductImage"]["name"]); // Add timestamp to file name
        $target_file = $target_dir . $file_name;
        $upload_ok = 1;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["ProductImage"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $upload_ok = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $upload_ok = 0;
        }

        // Check file size
        if ($_FILES["ProductImage"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $upload_ok = 0;
        }

        // Allow certain file formats
        if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $upload_ok = 0;
        }

        // Check if $upload_ok is set to 0 by an error
        if ($upload_ok == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["ProductImage"]["tmp_name"], $target_file)) {
                $product_image = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Update product
    $sql = "UPDATE products SET 
            ProductName = '$product_name', 
            ProductSKU = '$sku', 
            ProductImage = '$product_image', 
            ProductPrice = '$price' 
            WHERE ProductID = $product_id";

    if (mysqli_query($conn, $sql)) {
        // Remove existing category and brand links
        mysqli_query($conn, "DELETE FROM productcategories WHERE ProductID = $product_id");
        mysqli_query($conn, "DELETE FROM productbrands WHERE ProductID = $product_id");

        // Link new categories and brands
        foreach ($category_ids as $category_id) {
            $sql_category = "INSERT INTO productcategories (ProductID, CategoryID) VALUES ('$product_id', '$category_id')";
            mysqli_query($conn, $sql_category);
        }

        foreach ($brand_ids as $brand_id) {
            $sql_brand = "INSERT INTO productbrands (ProductID, BrandID) VALUES ('$product_id', '$brand_id')";
            mysqli_query($conn, $sql_brand);
        }

        header("Location: ../views/admin_page.php");
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>