<?php
session_start(); // Start the session
echo'heloo';
// Unset all of the session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: index.php');
exit();

?>