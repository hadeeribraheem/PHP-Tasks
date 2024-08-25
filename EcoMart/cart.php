<?php
session_start();
$title = 'Cart';
include_once 'guard/check_user_login.php';
include_once 'models/CartModel.php';

check_login();

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
    // If the user is not an customer, redirect to the customer dashboard or login page
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the item is already in the cart
    $cart_item = get_cart_item($user_id, $product_id);

    if ($cart_item) {
        // If the item is already in the cart, update the quantity
        $new_quantity = $cart_item['quantity'] + $quantity;
        update_cart_item($cart_item['cart_id'], $new_quantity);
    } else {
        // If the item is not in the cart, add it
        add_to_cart($user_id, $product_id, $quantity);
    }

    // Redirect back to the products page
    header('Location: productsDetails.php?product_id=' . $product_id);
    exit();
}



$user_id = $_SESSION['user_id'];

// Fetch cart items for this user
$cart_items = get_cart_items($user_id);  // Function to get the cart items for the user
$total = 0; // Initialize the total amount

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $cart_id = $_GET['cart_id'];

    // Call function to delete the item from the cart
    delete_cart_item($cart_id);

    // Redirect back to the cart page
    header('Location: cart.php');
    exit();
}
?>

<?php
    include_once 'templates/header.php';
    include_once 'templates/navbar.php';

?>
<body class="cart">
<div class="container">
    <h2 class="my-4">Shopping Cart</h2>
    <div class="row">
        <div class="col-lg-8">
            <?php if (!empty($cart_items)) { ?>
                <?php foreach ($cart_items as $item) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                    ?>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>" class="img-fluid">
                        </div>
                        <div class="col-md-6 mt-5">
                            <h5><?php echo $item['name']; ?></h5>
                            <p>Eligible for FREE delivery</p>
                            <p> Quantity: <span><?php echo $item['quantity']; ?></span></p>
                            <p>
                                <a href="cart.php?action=delete&cart_id=<?php echo $item['cart_id']; ?>" class="text-danger">Delete</a> |
                                <a href="#" class="text-primary">Save for later</a> |
                                <a href="#" class="text-secondary">Share</a>
                            </p>
                        </div>
                        <div class="col-md-3 text-end">
                            <p class="fw-bold">$<span id="subtotal-<?php echo $item['cart_id']; ?>"><?php echo $item['price'] * $item['quantity']; ?></span></p>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            <?php } else { ?>
                <p class="alert alert-warning">Your cart is empty.</p>
                <img src="images/emptycart.svg" class="img-fluid" alt="" style="max-width: 500px" />

            <?php } ?>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Cart Total</h4>
                    <hr>
                    <p class="card-text">Subtotal (<?php echo count($cart_items); ?> items): $<?php echo number_format($total, 2); ?></p>
                    <form action="orders.php" method="post">
                        <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                        <input type="hidden" name="shipping_address" value="">
                        <input type="hidden" name="payment_method" value="">
                        <input type="hidden" name="shipping_method" value="">
                        <button type="submit" class="btn btn-primary w-100 checkout-btn"
                            <?php if (empty($cart_items)) echo 'disabled'; ?>>
                            Proceed to Checkout
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
    include_once 'templates/footer.php';

?>
