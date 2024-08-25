<?php
session_start();
$title = 'Home';
include_once 'guard/check_user_login.php';
include_once 'models/ProductsModel.php';

check_login();

$products = get_products();

    // Check if the user is logged in and if they are an admin
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
        // If the user is not an customer, redirect to the customer dashboard or login page
        header('Location: index.php');
        exit();
    }
?>

<?php
    include_once 'templates/header.php';
    include_once 'templates/navbar.php';
?>
<body class="home">
<!-- Main Content -->
<div class="container mt-5">
    <div class="row">
        <?php if(isset($products) && sizeof($products) > 0) { ?>

            <?php
            $products = get_products();
            echo '<div class="row gy-4">';
            foreach ($products as $product) {
                echo '<div class="col-md-4 d-flex align-items-stretch productItem">';
                echo '<div class="card h-100 mb-4">';
                echo '<img id="productID" src="' . $product['image_url'] . '" class="img-fluid" alt="' . $product['name'] . '">';
                echo '<div class="card-body d-flex flex-column">';
                echo '<h5 class="card-title">' . $product['name'] . '</h5>';
                echo '<p class="card-text"><strong>Product Code:</strong> ' . $product['product_id'] . '<br>';
                echo '<strong>Price (Per Unit):</strong> $' . $product['price'] . '</p>';
                echo '<div class="mt-auto">';
                echo '<a href="productsDetails.php?product_id=' . $product['product_id'] . '" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">View Details</a>';
                echo '</div>';
                echo '</div>'; // End card-body
                echo '</div>'; // End card
                echo '</div>'; // End col
            }
            echo '</div>'; // End row

            ?>



        <?php } else {
            echo '<p class="alert alert-danger text-center m-3">There is no data</p>';
        }?>
    </div>
</div>

<?php include_once 'templates/footer.php';?>


