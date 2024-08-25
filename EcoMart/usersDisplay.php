<?php
session_start();
$title = 'Admin Dashboard';
include_once 'guard/check_user_login.php';
include_once 'models/UsersModel.php';
include_once 'models/OrdersModel.php';

check_login();

// Check if the user is logged in and if they are an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: index.php');
    exit();
}
// Fetch all users if no filter is applied
$data = get_users();
$employee_access = ['username','email','phone_number','Orders','Value'];

?>
<?php include_once 'templates/adminnavbar.php'; ?>


<body class="admin" style="background-color: #D8D9DA">
<div class="container">
    <div class="row">
        <br>
        <br>
        <?php if(isset($data) && sizeof($data) > 0) { ?>
            <h1 class="text-center mt-5"> Customers </h1>

            <table class="table table-bordered table-striped table-hover mt-5">
                <thead>
                <td>Username</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Num of Orders</td>
                <td>Total Spent</td>
                </thead>
                <tbody>
                <?php
                foreach($data as $user){
                    if($user['user_type']!== 'admin') {
                        echo '<tr>';
                        foreach ($employee_access as $access) {

                            if ($access == 'Orders') {
                                $Number = count_user_orders($user['user_id']);
                                echo '<td>' . $Number[0] . '</td>';
                            } elseif ($access == 'Value') {
                                $total_spent = get_total_spent_by_user($user['user_id']);
                                if ($total_spent == 0) {
                                    echo '<td>0</td>';
                                } else {
                                    echo '<td>' . $total_spent . '$' . '</td>';
                                }
                            } else {
                                echo '<td>' . $user[$access] . '</td>';
                            }
                        }
                        echo '</tr>';
                    }
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
