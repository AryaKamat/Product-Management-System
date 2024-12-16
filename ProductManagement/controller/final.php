<?php
session_start();

include '../connection.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'add':
        // Ensure user is a store manager
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'store_manager') {
            header("Location: login.php");
            exit();
        }

        // Fetch categories and brands
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
        break;

    case 'edit':
        // Ensure user is a store manager
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'store_manager') {
            header("Location: login.php");
            exit();
        }

        // Fetch categories and brands
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
            $category_ids = isset($_POST['category']) ? $_POST['category'] : []; 
            $brand_ids = isset($_POST['brand']) ? $_POST['brand'] : [];

            // Handle image upload
            $product_image = $product['ProductImage']; 
            if (!empty($_FILES['ProductImage']['name'])) {
                $target_dir = "../uploads/";
                $file_name = time() . '_' . basename($_FILES["ProductImage"]["name"]);
                $target_file = $target_dir . $file_name;
                $upload_ok = 1;
                $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Validate image upload
                $check = getimagesize($_FILES["ProductImage"]["tmp_name"]);
                if ($check === false) {
                    echo "File is not an image.";
                    $upload_ok = 0;
                }

                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $upload_ok = 0;
                }

                if ($_FILES["ProductImage"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $upload_ok = 0;
                }

                if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $upload_ok = 0;
                }

                if ($upload_ok == 1) {
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
        break;

    case 'filter':
        // Fetch categories and brands for filters
        $categories = $conn->query("SELECT * FROM categories");
        $brands = $conn->query("SELECT * FROM brands");

        // Fetch filter inputs
        $selectedCategories = isset($_GET['categories']) ? $_GET['categories'] : [];
        $selectedBrands = isset($_GET['brands']) ? $_GET['brands'] : [];
        $minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0.00;
        $maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 1000.00;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $itemsPerPage = 6;
        $offset = ($page - 1) * $itemsPerPage;

        // Construct SQL query
        $whereClauses = [];

        if (!empty($selectedCategories)) {
            $categoriesFilter = implode(',', array_map('intval', $selectedCategories));
            $whereClauses[] = "p.ProductID IN (SELECT ProductID FROM productcategories WHERE CategoryID IN ($categoriesFilter))";
        }

        if (!empty($selectedBrands)) {
            $brandsFilter = implode(',', array_map('intval', $selectedBrands));
            $whereClauses[] = "p.ProductID IN (SELECT ProductID FROM productbrands WHERE BrandID IN ($brandsFilter))";
        }

        if ($minPrice > 0 || $maxPrice < 1000) {
            $whereClauses[] = "p.ProductPrice BETWEEN $minPrice AND $maxPrice";
        }

        $whereSql = '';
        if (!empty($whereClauses)) {
            $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
        }

        // Determine sort order
        $orderSql = '';
        switch ($sort) {
            case 'name_asc':
                $orderSql = 'ORDER BY p.ProductName ASC';
                break;
            case 'name_desc':
                $orderSql = 'ORDER BY p.ProductName DESC';
                break;
            case 'newest':
                $orderSql = 'ORDER BY p.ProductID DESC';
                break;
            case 'price_asc':
                $orderSql = 'ORDER BY p.ProductPrice ASC';
                break;
            case 'price_desc':
                $orderSql = 'ORDER BY p.ProductPrice DESC';
                break;
            default:
                $orderSql = 'ORDER BY p.ProductID DESC'; // Default to newest
                break;
        }

        $sql = "SELECT DISTINCT p.ProductID, p.ProductName, p.ProductImage, p.ProductPrice,
                       GROUP_CONCAT(DISTINCT b.BrandName) AS brand_names,
                       GROUP_CONCAT(DISTINCT c.CategoryName) AS category_names
                FROM products p
                LEFT JOIN productbrands pb ON p.ProductID = pb.ProductID
                LEFT JOIN brands b ON pb.BrandID = b.BrandID
                LEFT JOIN productcategories pc ON p.ProductID = pc.ProductID
                LEFT JOIN categories c ON pc.CategoryID = c.CategoryID
                $whereSql
                GROUP BY p.ProductID
                $orderSql
                LIMIT $itemsPerPage OFFSET $offset";

        $products = $conn->query($sql);

        // Fetch total products count for pagination
        $countSql = "SELECT COUNT(DISTINCT p.ProductID) AS total
                     FROM products p
                     LEFT JOIN productbrands pb ON p.ProductID = pb.ProductID
                     LEFT JOIN brands b ON pb.BrandID = b.BrandID
                     LEFT JOIN productcategories pc ON p.ProductID = pc.ProductID
                     LEFT JOIN categories c ON pc.CategoryID = c.CategoryID
                     $whereSql";
        $totalResult = $conn->query($countSql);
        $totalRow = $totalResult->fetch_assoc();
        $totalItems = $totalRow['total'];
        $totalPages = ceil($totalItems / $itemsPerPage);

        break;

    case 'login':
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);

                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['firstname'] = $user['firstname'];
                    $_SESSION['email'] = $user['email'];

                    if ($user['role'] == 'store_manager') {
                        header("Location: ../views/admin_page.php");
                    } else {
                        header("Location: home2.php");
                    }
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "No user found with this email.";
            }
        }
        break;

    default:
        echo "Invalid action.";
        break;
}

mysqli_close($conn);
?>
