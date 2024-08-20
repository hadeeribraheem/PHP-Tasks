<?php
    session_start();
    $title = 'register';
    include_once 'models/UsersModel.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $data_check = get_specific_user($_POST['email'], $_POST['password']);

        if(is_array($data_check)){
            $_SESSION['email'] = $data_check['email'];
            $_SESSION['ID'] = $data_check['ID'];
            $_SESSION['username'] = $data_check['username'];
            $_SESSION['type'] = $data_check['type'];
            if($data_check['type'] == 'admin'){
                header('Location: admin.php');
            }
            else{
                header('location: complaints.php');
            }
        }
    }


?>

<?php
    include_once 'template/header.php';
?>
<div class="login mt-5">
    <div class="container">
        <h2 class="text-center">Login</h2>
        <?php
            if(isset($data_check)){
                if($data_check == false){
                    echo '<div class="alert alert-danger" role="alert"> Email or pass is wrong</div>';
                }
            }
        ?>
        <form method="post" style="max-width: 500px" class="m-auto">
            <div class="mb-3">
                <label>Email</label>
                <input class="form-control" name="email" type="email" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input class="form-control" name="password" type="password" required>
            </div>
            <input type="submit" class="btn btn-success w-100" value="login">
        </form>
    </div>
</div>
