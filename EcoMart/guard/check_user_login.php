<?php
    function check_login()
    {
        if(!(isset($_SESSION['user_id']))){
            header('location: index.php');
        }
        /*
        if($_SESSION['type'] != 'admin'){
            header('location: complaints.php');
        }*/
    }
?>