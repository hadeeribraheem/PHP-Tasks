<?php
session_start();

include_once 'guard/check_user_login.php';
check_login();

require_once 'classes/Cart.php';
require_once 'classes/Order.php';
require_once 'classes/OrderItem.php';
require_once 'classes/Product.php';
require_once 'classes/Payment.php';
require_once 'classes/Shipping.php';

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
    $_SESSION['shipping_address'] = $_POST['shipping_address'];
    $_SESSION['payment_method'] = $_POST['payment_method'];
    $_SESSION['shipping_method'] = $_POST['shipping_method'];

    $shipping_address = $_POST['shipping_address'];
    $payment_method = $_POST['payment_method'];
    $shipping_method = $_POST['shipping_method'];


    $_SESSION['missing_data'] = empty($shipping_address) || empty($payment_method) || empty($shipping_method);
    /*if ($missing_data) {
        // Trigger a modal popup to collect missing information
        header('Location: missingOrderedata_Modal.php');
        exit();  // Stop script execution after redirection
    }*/
    if ( $_SESSION['missing_data'] ) {
        // Trigger a modal popup to collect missing information
        header('Location:missingOrderedata_Modal.php');
        unset($_SESSION['missing_data']);
        exit();
        //include_once 'missingOrderedata_Modal.php';

    }
} elseif (!$_SESSION['missing_data']){
        header('Location:orderConfirmation.php?order_id=' . $_SESSION['order_id']);
        exit();

}
else {
        $msg = 'There are no orders. Make one and enjoy shopping with us!';

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
}
?>
