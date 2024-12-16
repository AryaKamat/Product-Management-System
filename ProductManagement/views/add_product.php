<?php


include '../controller/add.php';
include '../controller/nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/main.css">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    
    <div class="container">
        <h1>Add Product</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="ProductName">Product Name</label>
                <input type="text" id="ProductName" name="ProductName" required>
            </div>
            <div class="form-group">
                <label for="ProductImage">Product Image</label>
                <input type="file" id="ProductImage" name="ProductImage" required>
            </div>
            <div class="form-group">
                <label for="ProductSKU">Product SKU</label>
                <input type="text" id="ProductSKU" name="ProductSKU" required pattern="[A-Za-z0-9]+">
            </div>
            <div class="form-group">
                <label for="category">Product Category</label>
                <select id="category" name="category[]" multiple="multiple" style="width: 100%;">
                    <?php while ($row = mysqli_fetch_assoc($categories)): ?>
                        <option value="<?php echo $row['CategoryID']; ?>"><?php echo $row['CategoryName']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="brand">Product Brand</label>
                <select id="brand" name="brand[]" multiple="multiple" style="width: 100%;">
                    <?php while ($row = mysqli_fetch_assoc($brands)): ?>
                        <option value="<?php echo $row['BrandID']; ?>"><?php echo $row['BrandName']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Product Price</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Add Product</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="../js/select2.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
