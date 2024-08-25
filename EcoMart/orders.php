<?php
session_start();
include_once 'models/CartModel.php';
include_once 'models/OrdersModel.php';
include_once 'models/OrderItemsModel.php';
include_once 'models/PaymentsModel.php';
include_once 'models/ShippingModel.php';
include_once 'models/ProductsModel.php';

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
    // If the user is not an customer, redirect to the customer dashboard or login page
    header('Location: index.php');
    exit();
}
$user_id = $_SESSION['user_id'];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $shipping_address = $_POST['shipping_address'];
    $payment_method = $_POST['payment_method'];
    $shipping_method = $_POST['shipping_method'];
    $missing_data = empty($shipping_address) || empty($payment_method) || empty($shipping_method);

    if ($missing_data) {
        // Trigger a modal popup to collect missing information
        header('Location: missingOrderedata_Modal.php');
        // Calculate total amount based on cart items
        $total_amount = 0;
        $cart_items = get_cart_items($user_id);  // get the cart items for the user
        foreach ($cart_items as $item) {
            $total_amount += $item['price'] * $item['quantity'];
        }
        $order_date = date('Y-m-d H:i:s'); // Get the current date and time in the format YYYY-MM-DD HH:MM:SS
        $order_id = create_order($user_id, $total_amount,$order_date, $shipping_address );

        // Store order_id in the session
        $_SESSION['order_id'] = $order_id;

        // Save order items
        foreach ($cart_items as $item) {
            add_order_item($order_id, $item['product_id'], $item['quantity'], $item['price']);
        }

        // Save payment information
        $payment_id = add_payment($order_id, $payment_method, $total_amount, 'pending'); // pending status initially

        // Save shipping information
        $shipping_cost = ($shipping_method == 'express') ? 20.00 : 10.00;  //  shipping costs

        $current_date = new DateTime();

        // Add 5 days to the current date
        $expected_date = $current_date->modify('+5 days');

        $delivery_date = $expected_date->format('Y-m-d H:i:s');


        $delivery_date = date('Y-m-d H:i:s');
        $shipping_id = add_shipping($order_id, $shipping_method, $shipping_cost, date('Y-m-d H:i:s'), $delivery_date);
        clear_cart($user_id);

        header('Location: orderConfirmation.php?order_id=' . $order_id);
        exit();
    }

} else {
        $msg = 'There are no orders. Make one and enjoy shopping with us!';
}
?>

<?php

include_once 'templates/header.php';
include_once 'templates/navbar.php';
?>
<body style="margin-top: 100px;">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 d-flex flex-column justify-content-center align-items-center">
                <p class="alert alert-primary mb-3 w-800 text-center fw-bold"><?php echo $msg; ?></p>
                <img src="images/shopping.svg" class="img-fluid" alt="" />
            </div>
        </div>
    </div>
<?php
include_once 'templates/footer.php';
?>
