<?php
    session_start();
    $title = 'Home';
    include_once 'models/UsersModel.php';
    include_once 'guard/check_user_login.php';
    include_once 'classes/Users.php';

   //$user_obj = new Users('hadeer','hadeer@gmail.com');
    // $user_obj->getUsername();
    check_login();
    $employee_access = ['username','email','type'];

    if(isset($_SESSION['message'])){
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $where ='';
        // Check if type is set
        if (!empty($_POST['type']) && empty($_POST['pattern'])) {
            $where = 'WHERE type = "' . $_POST['type'] . '"';
            // Fetch users filtered by type only
            $data = get_users($where);
        }
        elseif (!empty($_POST['pattern']) && empty($_POST['type'])) {
            $where = 'where username like "%'.$_POST['pattern'].'%"';
            // Fetch users filtered by username pattern only
            $data = get_users($where);
        }
        elseif (!empty($_POST['type']) && !empty($_POST['pattern'])) {

            //Fetch users filtered by both type and username pattern
            $where = 'WHERE type = "' . $_POST['type'] . '" AND username LIKE "%' . $_POST['pattern'] . '%"';
            $data = get_users($where);

        } else {
            // Fetch all users if no filter is applied
            $data = get_users();
        }
    } else {
        // Default case when the form is not submitted
        $data = get_users();
    }


?>

<?php
    include_once 'template/header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-lg-6 mt-3">
            <!-- Filter Form -->
            <form method="POST" action="">
            <label>Filter by Type:</label>
            <select name="type" class="form-control d-inline-block w-auto mb-2">
                <option value="">All</option>
                <option value="client" <?php echo isset($_POST['type']) && $_POST['type'] == 'client' ? 'selected' : ''; ?>>Client</option>
                <option value="employee" <?php echo isset($_POST['type']) && $_POST['type'] == 'employee' ? 'selected' : ''; ?>>Employee</option>
                <option value="admin" <?php echo isset($_POST['type']) && $_POST['type'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
            <div class="mt-3">
                <label>Enter username</label>
                <input class="form-control" name="pattern">
            </div>
            <button type="submit" class="btn btn-primary mt-3 mb-5 w-100">Filter</button>
        </form>
        </div>
        <br>
        <?php //include_once 'layout/form.php' ?>
        <br>
        <?php if(isset($data) && sizeof($data) > 0) { ?>
                <?php
                    if(isset($message)){
                        echo '<p class="alert alert-success text-center m-3">'.$message.'</p>';

                    }
                ?>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                <td>Username</td>
                <td>Email</td>
                <td>Type</td>
                <td>Control</td>
                </thead>
                <tbody>
                <?php
                foreach($data as $user){
                    echo '<tr>';
                    foreach($employee_access as $access){
                        echo '<td>'.$user[$access].'</td>';
                    }
                    echo '<td><button class="btn me-2"><a href="update_user.php?user_id='.$user['ID'].'">Edit</a></button><button class="btn btn-danger">delete</button></td>';
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

<?php
include_once 'template/footer.php';
?>
