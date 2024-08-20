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
    function register_user($username,$email,$password,$phone){
        $conn = connectToDB();
        $sql = 'INSERT INTO users (username,email,password,phone,type) VALUES(:username,:email,:password,:phone,"client")';
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
?>