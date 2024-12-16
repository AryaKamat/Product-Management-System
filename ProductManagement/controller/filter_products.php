<?php
include '../connection.php';

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
?>
