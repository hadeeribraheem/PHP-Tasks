<?php

    include_once  './helpers/ConnectToDB.php';

    function get_users($where=''){
        $conn = connectToDB();
        $data = $conn -> query("SELECT * FROM users ".$where);
        return $data -> fetchAll();
    }
    function get_specific_user($email,$password){
        $conn = connectToDB();
        $data = $conn -> query('SELECT * FROM users where email = "'.$email.'"and password = "'.$password.'"');
        return $data -> fetch();
    }
    function get_user_by_email($email) {
        $conn = connectToDB();
        $data = $conn -> query('SELECT * FROM users where email = "'.$email.'"');
        return $data -> fetch();
    }


function register_user($username,$email,$password,$phone){
        $conn = connectToDB();
        $sql = 'INSERT INTO users (username,email,password,phone_number,user_type) VALUES(:username,:email,:password,:phone,"customer")';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username',$username);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':phone',$phone);
        $stmt->execute();

    }
    function checkEmail($email){
        $conn = connectToDB();
        $data = $conn -> query('SELECT * FROM users where email = "'.$email.'"');
        return $data -> fetch();
    }
    function update($username,$email,$password,$id){
        $conn = connectToDB();
        $sql = 'update users set username=:username, email= :email,password=:password where ID=:id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username',$username);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':id',$id);
        $stmt->execute();

    }
    function count_customers_with_orders() {
        $conn = connectToDB();
        $sql = "
            SELECT COUNT(DISTINCT users.user_id) AS customer_count
            FROM users
            JOIN orders ON users.user_id = orders.user_id
            WHERE users.user_type = 'customer'
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['customer_count'];
    }

?>