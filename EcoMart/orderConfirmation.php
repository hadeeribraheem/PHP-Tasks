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

if(isset($_SESSION['order_id'])){
$order_id = $_SESSION['order_id'] ;

$order_items = get_order_items($order_id);
    $payment_details = get_payment_details($order_id);
    $shipping_details = get_shipping_details($order_id);
    $order_details = get_order_details_by_id($order_id);


?>

<?php
include_once 'templates/header.php';
include_once 'templates/navbar.php';
?>

<body style="margin-top: 80px;">
<div class="container mt-5">
    <h2>Order Details</h2>

    <p>Placed on <?php echo date('F j, Y, g:i a', strtotime($order_details['order_date'])); ?></p>

    <div class="row">
        <div class="col-md-8">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($order_items as $item) { ?>
                    <tr>
                        <td><?php echo $item['name']; ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="text-end">
                <p><strong>Subtotal:</strong> $<?php echo number_format($order_details['total_amount'], 2); ?></p>
                <p><strong>Shipping (<?php echo $shipping_details[0]['shipping_method']; ?>):</strong> $<?php echo number_format($shipping_details[0]['shipping_cost'], 2); ?></p>
                <h4><strong>Total:</strong> $<?php echo number_format($order_details['total_amount'], 2); ?> CAD</h4>
            </div>
        </div>
        <div class="col-md-4">

            <div class="mb-3">
                <h5>Status</h5>
                <p><?php echo $payment_details[0]['status']; ?></p>
            </div>


            <div class="mb-3">
                <h5>Shipping Address</h5>
                <p><?php echo $order_details['shipping_address']; ?></p>
            </div>
        </div>
    </div>

    <!-- Account dont implemented-->
    <a href="#" class="btn btn-primary mt-1">Return to Account details</a>
</div>


<?php
include_once 'templates/footer.php';
?>

<?php
}
else{
    header('Location: Home.php');
}
    ?>
