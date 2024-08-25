<?php
session_start();
include_once 'guard/check_user_login.php';
include_once 'models/ProductsModel.php';
include_once 'models/ProductImagesModel.php';

check_login();
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
    // If the user is not an customer, redirect to the customer dashboard or login page
    header('Location: index.php');
    exit();
}

if (!$product_id) {
    header('Location: Home.php');
    exit();
}

// Fetch product details
$product = get_product_by_id($product_id);

$title = $product['name'];



// Fetch product images
$images = get_product_images($product_id);

if (!$product) {
    echo "<p class='alert alert-danger'>Product not found.</p>";
    exit();
}
?>

<?php
include_once 'templates/header.php';
include_once 'templates/navbar.php';
?>
<body style="margin-top: 80px;">
<div class="container mt-5">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <!-- Product Images Carousel -->
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($images as $index => $image) { ?>
                        <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">
                            <img src="<?php echo $image['image_url']; ?>" class="d-block " alt="<?php echo $image['alt_text']; ?>" style="max-width:100%;
    height: auto;
    object-fit: contain;
    max-height: 500px;
    margin: 0 auto;">
                        </div>
                    <?php } ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev" >
                    <span class="carousel-control-prev-icon bg-dark" aria-hidden="true" ></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-md-6">
            <h2><?php echo $product['name']; ?></h2>
            <p><strong>Price:</strong>$<?php echo number_format($product['price'], 2); ?></p>
            <p><strong>Description:</strong> <?php echo $product['description']; ?></p>
            <p><strong>Stock Quantity:</strong> <?php echo $product['stock_quantity']; ?></p>
            <form action="cart.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-primary d-flex justify-content-center align-items-center">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
<?php
    include_once 'templates/footer.php';
?>