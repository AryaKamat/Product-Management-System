<?php
session_start();

include '../connection.php';
include '../controller/filter_products.php';
include '../controller/nav.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/main.css">   
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <!-- Filter Section -->
        <div class="col-md-3">
            <h3>Category</h3>
            <form id="filterForm" action="" method="GET">
                <?php while ($cat = $categories->fetch_assoc()) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $cat['CategoryID']; ?>" <?php echo in_array($cat['CategoryID'], $selectedCategories) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="category">
                            <?php echo $cat['CategoryName']; ?>
                        </label>
                    </div>
                <?php } ?>

                <h3>Brands</h3>
                <?php while ($brand = $brands->fetch_assoc()) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="brands[]" value="<?php echo $brand['BrandID']; ?>" <?php echo in_array($brand['BrandID'], $selectedBrands) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="brand">
                            <?php echo $brand['BrandName']; ?>
                        </label>
                    </div>
                <?php } ?>

                <h3>Price</h3>
                <input type="number" name="min_price" placeholder="Min Price" value="<?php echo htmlspecialchars($minPrice); ?>">
                <input type="number" name="max_price" placeholder="Max Price" value="<?php echo htmlspecialchars($maxPrice); ?>">

                <h3>Sort By</h3>
                <select name="sort" class="form-select">
                    <option value="name_asc" <?php echo ($sort == 'name_asc') ? 'selected' : ''; ?>>Name A-Z</option>
                    <option value="name_desc" <?php echo ($sort == 'name_desc') ? 'selected' : ''; ?>>Name Z-A</option>
                    <option value="newest" <?php echo ($sort == 'newest') ? 'selected' : ''; ?>>Newest First</option>
                    <option value="price_asc" <?php echo ($sort == 'price_asc') ? 'selected' : ''; ?>>Price: Lowest First</option>
                    <option value="price_desc" <?php echo ($sort == 'price_desc') ? 'selected' : ''; ?>>Price: Highest First</option>
                </select>
            </form>
        </div>

        <!-- Product Listing Section -->
        <div class="col-md-9">
            <div class="row" id="productList">
                <?php if ($products->num_rows > 0) { ?>
                    <?php while ($product = $products->fetch_assoc()) { ?>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img src="<?php echo $product['ProductImage']; ?>" class="card-img-top" alt="<?php echo $product['ProductName']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product['ProductName']; ?></h5>
                                    <p class="card-text">Brand: <?php echo $product['brand_names']; ?></p>
                                    <p class="card-text">Category: <?php echo $product['category_names']; ?></p>
                                    <p class="card-text">₹<?php echo $product['ProductPrice']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No products found.</p>
                <?php } ?>
            </div>

            <?php if ($page < $totalPages) { ?>
                <div class="row">
                    <div class="col-12 text-center">
                        <button id="loadMore" class="btn btn-secondary" style="margin-bottom:20px">Load More</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="js/main.js" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
<script>
    const currentPage = <?php echo $page; ?>;
    const totalPages = <?php echo $totalPages; ?>;
</script>
<script src="../js/loadmore.js"></script>

<?php 
include '../controller/footer.php';
?>

</body>
</html>

<?php $conn->close(); ?>
