<?php
session_start();

include_once 'guard/check_user_login.php';
check_login();

require_once 'classes/Cart.php';
require_once 'classes/Order.php';
require_once 'classes/OrderItem.php';
require_once 'classes/Product.php';
require_once 'classes/Shipping.php';
require_once 'classes/Payment.php';

// Assuming user ID is stored in the session
$user_id = $_SESSION['user_id'];

//objects to use
$Order = new Order();
$OrderItem = new OrderItem();
$Payment = new Payment();
$Shipping = new Shipping();
$Cart = new Cart();


// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Calculate total amount based on cart items
    $total_amount = 0;
    $cart_items = $Cart->getCartItems($user_id);
    //$cart_items = get_cart_items($user_id);  // get the cart items for the user
    foreach ($cart_items as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }
    $order_date = date('Y-m-d H:i:s'); // Get the current date and time in the format YYYY-MM-DD HH:MM:SS

    // Store order_id in the session
    $order_id = $Order->createOrder($user_id, $total_amount,$order_date, $_SESSION['shipping_address'] );
    $_SESSION['order_id'] = $order_id;

    //$order_id = create_order($user_id, $total_amount,$order_date, $shipping_address );

    // Get form data
    $shipping_address = $_POST['shipping_address'];
    $shipping_method = $_POST['shipping_method'];
    $payment_method = $_POST['payment_method'];

    // Update the orders table with the shipping address
    $Order->updateOrderShippingAddress($order_id, $shipping_address);
    //update_order_shipping_address($order_id, $shipping_address);


    // Save shipping information
    $shipping_cost = ($shipping_method == 'express') ? 20.00 : 10.00;  //  shipping costs
    $current_date = new DateTime();
    // Add 5 days to the current date
    $expected_date = $current_date->modify('+5 days');
    $delivery_date = $expected_date->format('Y-m-d H:i:s');
    $shipping_id = $Shipping->addShipping($order_id,$shipping_method, $shipping_cost, date('Y-m-d H:i:s'), $delivery_date);

    // Calculate total amount based on cart items
    $cart_items = $Cart->getCartItems($user_id);
    $total_amount = 0;


    // Save order items
    foreach ($cart_items as $item) {
        $OrderItem->addOrderItem($order_id, $item['product_id'], $item['quantity'], $item['price']);
    }

    // Save payment information
    $payment_id = $Payment->addPayment($order_id, $_SESSION['payment_method'], $total_amount, 'pending');
    $Order->updateOrderWithPayment($order_id, $payment_id);
    //update the payment details
    $Payment->updatePaymentDetails($order_id, $payment_method);

    $Cart->clearCart($user_id);

    header('location:orders.php');
}
?>



<?php

include_once 'templates/header.php';
?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Please provide the missing order information</h5>
            </div>
            <div class="modal-body">
                <form method="post" style="
                                    display: block !important;
                                    justify-content: center;
                                    padding: 0rem 1rem !important;
                ">
                    <div class="mb-3">
                        <label class="form-label">Shipping Address</label>
                        <input type="text" class="form-control" id="shipping_address" name="shipping_address" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="credit_card">Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cash_on_delivery">Cash on Delivery</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="shipping_method" class="form-label">Shipping Method</label>
                        <select class="form-select" id="shipping_method" name="shipping_method" required>
                            <option value="standard">Standard</option>
                            <option value="express">Express</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Automatically trigger the modal when the page loads
    document.addEventListener("DOMContentLoaded", function() {
        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'),{
            backdrop: 'static', // Prevent clicking outside to close the modal
            keyboard: false // Prevent closing with the Escape key
        });
        myModal.show();
    });
</script>

<?php
include_once 'templates/footer.php';
?>
