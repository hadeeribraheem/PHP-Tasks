<?php
session_start();
$title = 'Admin Dashboard';
include_once 'guard/check_user_login.php';
require_once 'classes/User.php';
require_once 'classes/Product.php';

check_login();

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: index.php');
    exit();
}

//objects declaration
$Product = new Product();
$User = new User();

$categories  = $Product->getCategories();
    //getCategories();

?>
<?php include_once 'templates/adminnavbar.php'; ?>
<h1>Add Product</h1>
<form action="add_product.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="productName" class="form-label">Name</label>
        <input type="text" class="form-control" id="productName" name="name" required>
    </div>
    <div class="mb-3">
        <label for="productPrice" class="form-label">Price</label>
        <input type="number" class="form-control" id="productPrice" name="price" required>
    </div>
    <div class="mb-3">
        <label for="productDescription" class="form-label">Description</label>
        <textarea class="form-control" id="productDescription" name="description" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="productStock" class="form-label">Stock Quantity</label>
        <input type="number" class="form-control" id="productStock" name="stock_quantity" required>
    </div>
    <div class="mb-3">
        <label for="productImage" class="form-label">Image</label>
        <input type="file" class="form-control" id="productImage" name="image[]" multiple required>
    </div>
    <div class="mb-3">
        <label for="productCategory" class="form-label">Category</label>
        <select class="form-control" id="productCategory" name="category_id" required>
            <option value="" disabled selected>Select a category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary mb-3">Save</button>
</form>


<?php include_once 'templates/footer.php'; ?>
