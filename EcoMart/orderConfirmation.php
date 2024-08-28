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

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
    // If the user is not a customer, redirect to the customer dashboard or login page
    header('Location: index.php');
    exit();
}

// Objects
$Order = new Order();
$OrderItem = new OrderItem();
$Payment = new Payment();
$Shipping = new Shipping();

// Retrieve all orders for the user
$orders = $Order->getAllOrdersByUserId($_SESSION['user_id']);
include_once 'templates/header.php';
include_once 'templates/navbar.php';
?>

<body style="margin-top: 80px;">
<div class="container mt-5">
    <h2>My Orders</h2>

    <?php if (!empty($orders)) { ?>
        <?php foreach ($orders as $order) { ?>
            <div class="order-summary mb-4">
                <div class="order-header">
                    <h4>Order #<?php echo $order['order_id']; ?> - Placed on <?php echo date('F j, Y, g:i a', strtotime($order['order_date'])); ?></h4>
                </div>
                <div class="order-details">
                    <?php
                    // Get the order details
                    $order_items = $OrderItem->getOrderItemsByOrderId($order['order_id']);
                    $payment_details = $Payment->getPaymentDetails($order['order_id']);
                    $shipping_details = $Shipping->getShippingDetails($order['order_id']);
                    ?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($order_items as $item) { ?>
                            <tr>
                                <td><?php echo $item['name']; ?></td>
                                <td><img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>" style="width: 100px;"></td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="text-end">
                        <p><strong>Subtotal:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
                        <p><strong>Shipping:</strong> $<?php echo number_format($shipping_details[0]['shipping_cost'], 2); ?></p>
                        <h4><strong>Total:</strong> $<?php echo number_format($order['total_amount'], 2); ?></h4>
                    </div>
                </div>
                <div class="order-summary-footer">
                    <div class="mb-3">
                        <h5>Status</h5>
                        <p><?php echo $payment_details[0]['status']; ?></p>
                    </div>
                    <div class="mb-3">
                        <h5>Shipping Address</h5>
                        <p><?php echo $order['shipping_address']; ?></p>
                    </div>
                    <div class="mb-3">
                        <h5>Shipping Method</h5>
                        <p><?php echo $shipping_details[0]['shipping_method']; ?></p>
                    </div>
                    <div class="mb-3">
                        <h5>Delivery Date</h5>
                        <p><?php echo date('F j, Y', strtotime($shipping_details[0]['delivery_date'])); ?></p>
                    </div>
                </div>
            </div>
            <hr>
        <?php } ?>
    <?php } else { ?>
        <p>You have no orders yet. <a href="Home.php" style="text-decoration: none; color: #295F98; font-size: large;font-weight: 500;">Start shopping now!</a></p>
        <div class="d-flex justify-content-center align-items-center">
            <img src="images/shopping.svg" class="img-fluid" alt="" style="max-width: 700px; margin: auto;"/>
        </div>
    <?php } ?>
</div>

<?php include_once 'templates/footer.php'; ?>
