<?php
    function connectToDB(){
        $info = 'mysql:host=localhost;
                    dbname=ecommerce';
        $username = 'root';
        $password = '';

        $con = new PDO($info, $username, $password);
        $con ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $con;
    }
?>