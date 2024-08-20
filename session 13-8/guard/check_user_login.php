<?php
    function check_login()
    {
        if(!(isset($_SESSION['ID']))){
            header('location: login.php');
        }
        /*
        if($_SESSION['type'] != 'admin'){
            header('location: complaints.php');
        }*/
    }
?>