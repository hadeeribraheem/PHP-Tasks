<?php
session_start();
$title = 'Admin Dashboard';
include_once 'guard/check_user_login.php';
include_once 'models/UsersModel.php';
include_once 'models/ProductsModel.php';
include_once 'models/OrdersModel.php';
check_login();

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: index.php');
    exit();
}


// Determine sorting order from form submission
$sort_order = isset($_POST['sort']) && $_POST['sort'] == 'DESC' ? 'DESC' : 'ASC';

$Products = getProductsBy($sort_order);

$NumOFcustomers = count_customers_with_orders();

$total_sum = get_total_amount_sum();

// Determine the new sort order for the next button click
$new_sort_order = $sort_order == 'ASC' ? 'DESC' : 'ASC';
$button_label = $sort_order == 'ASC' ? 'Sort Descending' : 'Sort Ascending';


$employee_access = ['name','image_url','description','stock_quantity','price',];

?>
<?php include_once 'templates/adminnavbar.php'; ?>

<h1>Dashboard</h1>
<p>Welcome to the Admin Dashboard!</p>
<div class="row dashboard">
    <div class="col-lg-4 card infoCard sales_card ">
        <div class="card_body">
            <div class="card_title">
                <h5>
                    Sales
                </h5>
            </div>
            <div class="d-flex align-items-center">
                <div class="cardIcon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                    <h6><?php echo $total_sum.'$' ?></h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card infoCard customers_card">
            <div class="card_body">
                <div class="card_title">
                    <h5>
                        Customers
                    </h5>
                </div>
                <div class="d-flex align-items-center">
                    <div class="cardIcon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                        <h6><?php echo $NumOFcustomers ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <?php if(isset($Products) && sizeof($Products) > 0) { ?>
            <form method="post" class="mt-5 mb-3">
                <input type="hidden" name="sort" value="<?php echo $new_sort_order; ?>">
                <button type="submit" class="btn btn-primary"><?php echo $button_label; ?></button>
            </form>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <td>Product name</td>
                <td>Image</td>
                <td>Description</td>
                <td>Stock Quantity</td>
                <td>Price</td>
                </thead>
                <tbody>
                <?php
                foreach($Products as $product){
                    echo '<tr>';
                    foreach($employee_access as $access){
                        if($product[$access] == $product['image_url']){
                            echo '<td><img src="'.$product[$access].'" alt="Product Image" class="img-fluid" style="max-width:100px;max-height:100px;width:auto;height:auto;"></td>';
                        }
                        elseif($product[$access] == $product['price']){
                            echo '<td>'.$product[$access].'$'.'</td>';
                        }
                        else{
                            echo '<td>'.$product[$access].'</td>';}
                    }
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        <?php } else {
            echo '<p class="alert alert-danger text-center m-3">There is no data</p>';
        }?>
    </div>
</div>

<?php include_once 'templates/footer.php'; ?>
