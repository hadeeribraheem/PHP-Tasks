<?php
    session_start();
    include_once 'guard/check_user_login.php';
    include_once 'models/UsersModel.php';
    include("models/ProductsModel.php");
    include_once ('models/ProductImagesModel.php');

check_login();
    // Check if the user is logged in and if they are an admin
    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
        header('Location: index.php');
        exit();
    }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $stock_quantity = $_POST['stock_quantity'];
    $category_id = $_POST['category_id'];

    // Handle the image uploads
    if (is_array($_FILES['image']['name'])) {
        // Get the first image as the primary image
        $primary_image_name = $_FILES['image']['name'][0];
        $primary_image_tmp_name = $_FILES['image']['tmp_name'][0];
        $primary_image_url = 'uploads/' . $primary_image_name;

        // Move the primary image to its final destination
        move_uploaded_file($primary_image_tmp_name, $primary_image_url);

        // Add the product to the database
        $product_id = addProduct($name, $description, $price, $stock_quantity, $category_id, $primary_image_url);

        // Handle the rest of the images
        foreach ($_FILES['image']['name'] as $key => $image_name) {
            if ($key == 0) continue; // Skip the primary image as it is already handled

            if (!empty($image_name)) {
                $image_tmp_name = $_FILES['image']['tmp_name'][$key];
                $image_url = 'uploads/' . $image_name;
                move_uploaded_file($image_tmp_name, $image_url);

                // Insert image data into the `product_images` table
                saveImageToProductImages($product_id, $image_url);
            }
        }
    }

    $msg = "Product and images uploaded successfully!";

?>
<?php
include_once 'templates/adminnavbar.php';
?>
    <div class="row">
        <div class="col-lg-12 d-flex flex-column justify-content-center align-items-center">
            <p class="alert alert-primary mb-3 w-800 text-center fw-bold"><?php echo $msg; ?></p>
            <img src="images/success.svg" class="img-fluid" alt="" />
        </div>
    </div>
<?php
include_once 'templates/footer.php';
?>
<?php
}
    ?>
