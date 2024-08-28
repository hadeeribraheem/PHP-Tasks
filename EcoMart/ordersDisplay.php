<?php
session_start();

include_once 'guard/check_user_login.php';
check_login();

$title = 'Admin Dashboard';
require_once 'classes/Order.php';
require_once 'classes/User.php';
require_once 'classes/Product.php';

include_once 'guard/check_user_login.php';
check_login();

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: index.php');
    exit();
}


// Determine sorting order from form submission
$sort_order = isset($_POST['sort']) && $_POST['sort'] == 'DESC' ? 'DESC' : 'ASC';

$orderinfo = new Order();
$Orders = $orderinfo->getOrdersBy($sort_order);
//$Orders = getOrdersBy($sort_order);

// Determine the new sort order for the next button click
$new_sort_order = $sort_order == 'ASC' ? 'DESC' : 'ASC';
$button_label = $sort_order == 'ASC' ? 'Sort Descending' : 'Sort Ascending';

$employee_access = ['user_id','total_amount','order_date','status','shipping_address','quantity','product_id','price'];

?>
<?php include_once 'templates/adminnavbar.php'; ?>

<h1>Orders Dashboard</h1>
<div class="row">
    <div class="col-lg-12">
        <?php if(isset($Orders) && sizeof($Orders) > 0) { ?>
            <form method="post" class="mt-5 mb-3">
                <input type="hidden" name="sort" value="<?php echo $new_sort_order; ?>">
                <button type="submit" class="btn btn-primary"><?php echo $button_label; ?></button>
            </form>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <td>User name</td>
                <td>Total Amount</td>
                <td>Order Date</td>
                <td>Status</td>
                <td>Shipping Address</td>
                <th>Quantity</th>
                <th>Product name</th>
                <th>Product image</th>
                <th>Price</th>
                </thead>
                <tbody>
                <?php
                foreach($Orders as $order){
                    echo '<tr>';
                    foreach($employee_access as $access){
                        if($order[$access] == $order['user_id']){
                            $where = 'WHERE user_id ="'.$order['user_id'].'"';
                            $Users = new User();
                            $user = $Users->getUsers($where);
                            //$user = get_users($where);
                            echo '<td>'.$user[0]['username'].'</td>';

                        }
                        elseif($order[$access] == $order['product_id']){
                            $Prouctinfo = new Product();
                            $product= $Prouctinfo->getProductById($order['product_id']);
                            //$product = get_product_by_id($order['product_id']);
                            echo '<td>'.$product['name'].'</td>';
                            echo '<td><img src="'.$product['image_url'].'" alt="Product Image" class="img-fluid" style="max-width:100px;max-height:100px;width:auto;height:auto;"></td>';
                        }
                        elseif($order[$access] == $order['quantity']){
                            echo '<td>'.$order[$access].'</td>';
                        }
                        else{
                            echo '<td>'.$order[$access].'</td>';
                        }
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
