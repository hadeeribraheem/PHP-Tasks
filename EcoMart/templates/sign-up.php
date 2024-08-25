<?php
include_once 'models/UsersModel.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];

    $username_error = $email_error = $pass_error = $phone_error = "";

    // Validate username
    if (empty($_POST["username"])) {
        $username_error = "Username should not be empty.";
    }
    // Validate pass
    if (empty($_POST["password"])) {
        $pass_error = "password should not be empty.";
    }
    // Validate phone
    if (empty($_POST["phone_number"])) {
        $phone_error = "phone number should not be empty.";
    }
    // Validate email
    // Validate email
    if (empty($email)) {
        $email_error = "Email should not be empty.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "This is an invalid email.";
    } else {
        // Check if the email already exists in the database
        $check_mail = checkEmail($email);
        if ($check_mail) {
            $email_error = "Email already exists.";
        }
    }


    // If there are no erors, proceed with inserting the data
    if (empty($username_error) && empty($email_error) && empty($pass_error)&& empty($phone_error)) {
        register_user($username,$email,$password,$phone_number);
            header('Location: index.php');
            exit();

    }
}
?>


<form class="sign-up-form" method="post">
    <h2 class="title">Sign up</h2>
    <div class="input-field">
        <i class="fas fa-user"></i>
        <input type="text" placeholder="Username" name="username" value="<?php if(isset($_POST["username"])) echo $_POST["username"] ?>" required>

    </div>
    <?php
    if (!empty($username_error))  {
        ?>
        <div class="alert alert-danger m-2" role="alert">
            <p class="alert alert-danger"><?php echo htmlspecialchars($username_error); ?></p>
        </div>
    <?php } ?>
    <div class="input-field">
        <i class="fas fa-envelope"></i>
        <input type="email" placeholder="Email" name="email" required value="<?php if(isset($_POST["email"])) echo $_POST["email"] ?>">

    </div>
    <?php
    if (!empty($email_error))  {
        ?>
        <div class="alert alert-danger m-2" role="alert">
            <?php echo htmlspecialchars($email_error); ?>
        </div>
        <?php
    }
    ?>
    <div class="input-field">
        <i class="fa-solid fa-phone"></i>
        <input type="text" placeholder="Phone number" name="phone_number" required value="<?php if(isset($_POST["phone_number"])) echo $_POST["phone_number"] ?>">

    </div>
    <?php
    if (!empty($phone_error))  {
        ?>
        <div class="alert alert-danger m-2" role="alert">
            <?php echo htmlspecialchars($phone_error); ?>
        </div>
        <?php
    }
    ?>
    <div class="input-field">
        <i class="fas fa-lock"></i>
        <input type="password" placeholder="Password" name="password" required value="<?php if(isset($_POST["password"])) echo $_POST["password"] ?>">

    </div>
    <?php
    if (!empty($pass_error))  {
        ?>
        <div class="alert alert-danger m-2" role="alert">
            <?php echo htmlspecialchars($pass_error); ?>
        </div>
        <?php
    }
    ?>
    <input type="submit" class="btn" name="register" value="Sign up">
    <p class="social-text">Or Sign up with social platforms</p>
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