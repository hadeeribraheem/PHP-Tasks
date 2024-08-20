<?php
session_start();
$title = 'Register';
include_once 'models/UsersModel.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $check_mail = checkEmail($_POST['email']);

    if ($check_mail == false){
        $data_check = register_user($_POST['username'], $_POST['email'], $_POST['password'], $_POST['phone']);
    }
}
?>

<?php
include_once 'template/header.php';
?>
<div class="login mt-5">
    <div class="container">
        <h2 class="text-center">Register</h2>
        <form method="post" style="max-width: 500px" class="m-auto">
            <div class="mb-3">
                <label>Username</label>
                <input class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input class="form-control" name="email" type="email" required>
                <?php
                    if (isset($check_mail) && is_array($check_mail)) {
                        echo '<div class="alert alert-danger" role="alert"> Email exist</div>';
                    }
                ?>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input class="form-control" name="password" type="password" required>
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input class="form-control" name="phone" required>
            </div>

            <input type="submit" class="btn btn-success w-100" value="Register">

        </form>

    </div>
</div>
<?php
include_once 'template/footer.php';
?>