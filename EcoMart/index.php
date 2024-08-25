<?php
    $title = 'EcoMart';
    include_once 'templates/header.php';

$title = 'EcoMart';
include_once 'templates/header.php';

?>

<body class="index">
<div class="page_container">
    <div class="forms-container">
        <div class="signin-signup">
            <?php include_once 'templates/sign-in.php'; ?>
            <?php include_once 'templates/sign-up.php'; ?>
        </div>
    </div>

    <div class="panels-container">
        <div class="panel left-panel">
            <div class="content">
                <h3>New here ?</h3>
                <p>
                    Your one-stop shop for the best products at unbeatable prices. Experience the joy of seamless shopping
                </p>
                <button class="btn transparent" id="sign-up-btn">
                    Sign up
                </button>
            </div>
            <img src="images/register.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
            <div class="content">
                <h3>One of us ?</h3>
                <p>
                    Sign in to your account to track your orders, view your wish list, and access exclusive deals just for you
                </p>
                <button class="btn transparent" id="sign-in-btn">
                    Sign in
                </button>
            </div>
            <img src="images/log.svg" class="image" alt="" />
        </div>
    </div>
</div>
<script src="js/app.js"></script>

<?php include_once 'templates/footer.php';?>
