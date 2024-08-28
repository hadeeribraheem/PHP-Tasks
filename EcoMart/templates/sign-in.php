<?php
    session_start();
    $title = 'Login';
    require_once 'classes/User.php';

    $email_error = '';
    $password_error = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){

        $User = new User();
        // Check if the email exists
        $user = $User->getUserByEmail($_POST['email']);
        //$user = get_user_by_email($_POST['email']);
        $password = $User->getSpecificUser($_POST['email'],$_POST['password']);
        //$password = get_specific_user($_POST['email'],$_POST['password']);

        if($user){
            // Email exists, now check the password
            if($password){
                // Password is correct
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['user_type'];

                // Check user type and redirect accordingly
                if ($user['user_type'] === 'admin') {
                    header('Location:Admin.php'); // Redirect to admin dashboard
                    exit(); // Ensure the script stops executing after redirection
                } else {
                    header('Location: Home.php'); // Redirect to customer dashboard
                    exit(); // Ensure the script stops executing after redirection
                }

            } else {
                // Password is incorrect
                $password_error = 'Password is incorrect';
            }
        } else {
            // Email does not exist
            $email_error = 'Email does not exist';
        }
    }
?>

<form class="sign-in-form" method="post">
    <h2 class="title">Sign in</h2>
    <div class="input-field">
        <i class="fas fa-user"></i>
        <input type="email" placeholder="Email" name="email" required>
    </div>
    <?php
    if ($email_error) {
        ?>
        <div class="alert alert-danger m-2" role="alert">
            <?php echo $email_error; ?>
        </div>
        <?php
    }
    ?>
    <div class="input-field">
        <i class="fas fa-lock"></i>
        <input type="password" placeholder="Password" name="password" required>

    </div>
    <?php
    if ($password_error) {
        ?>
        <div class="alert alert-danger m-2" role="alert">
            <?php echo $password_error; ?>
        </div>
        <?php
    }
    ?>
    <input type="submit" value="Login"  name="login"  class="btn solid" />
    <p class="social-text">Or Sign in with social platforms</p>
    <div class="social-media">
        <a href="#" class="social-icon">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="social-icon">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="#" class="social-icon">
            <i class="fab fa-google"></i>
        </a>
        <a href="#" class="social-icon">
            <i class="fab fa-linkedin-in"></i>
        </a>
    </div>
</form>