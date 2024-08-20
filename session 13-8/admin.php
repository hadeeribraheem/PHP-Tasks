<?php
session_start();
$title = 'admin';
include_once 'models/ComplaintsModel.php';
include_once 'guard/check_user_login.php';
check_login();

$data = get_complaints();
$employee_access =['username','email','phone','complaint']
?>

<?php
include_once 'template/header.php';
?>

<div class="container">
    <div class="row">
        <br>
        <br>
        <?php if(isset($data) && sizeof($data) > 0) { ?>
            <h1 class="text-center mt-5"> Complaints </h1>

            <table class="table table-bordered table-striped table-hover mt-5">
                <thead>
                <td>Username</td>
                <td>Email</td>
                <td>Phone</td>
                <td>complaint</td>
                </thead>
                <tbody>
                <?php
                foreach($data as $user){
                    echo '<tr>';
                    foreach($employee_access as $access){
                        echo '<td>'.$user[$access].'</td>';
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

<?php
include_once 'template/footer.php';
?>
