<?php


include '../controller/edit.php';
include '../controller/nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/main.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="ProductName">Product Name</label>
                <input type="text" id="ProductName" name="ProductName" value="<?php echo htmlspecialchars($product['ProductName']); ?>" required class="form-control">
            </div>
            <div class="form-group">
                <label for="ProductImage">Product Image</label>
                <input type="file" id="ProductImage" name="ProductImage" class="form-control">
                <?php if ($product['ProductImage']) { ?>
                    <img src="<?php echo htmlspecialchars($product['ProductImage']); ?>" alt="Product Image" width="100">
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="ProductSKU">Product SKU</label>
                <input type="text" id="ProductSKU" name="ProductSKU" value="<?php echo htmlspecialchars($product['ProductSKU']); ?>" required pattern="[A-Za-z0-9]+" class="form-control">
            </div>
            <div class="form-group">
                <label for="category">Product Category</label>
                <select id="category" name="category[]" multiple="multiple" class="form-control">
                    <?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
                        <option value="<?php echo $cat['CategoryID']; ?>" <?php echo in_array($cat['CategoryID'], $selected_categories) ? 'selected' : ''; ?>>
                            <?php echo $cat['CategoryName']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="brand">Product Brand</label>
                <select id="brand" name="brand[]" multiple="multiple" class="form-control">
                    <?php while ($brand = mysqli_fetch_assoc($brands)) { ?>
                        <option value="<?php echo $brand['BrandID']; ?>" <?php echo in_array($brand['BrandID'], $selected_brands) ? 'selected' : ''; ?>>
                            <?php echo $brand['BrandName']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Product Price</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['ProductPrice']); ?>" step="0.01" required class="form-control">
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Product</button>
            <a href="admin_page.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="../js/select2.js"></script>
</body>
</html>
