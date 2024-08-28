<?php
require_once 'Database.php';

class User
{
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function getUsers($where = '') {
        $stmt = $this->conn->query("SELECT * FROM users " . $where);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSpecificUser($email, $password) {
        $stmt = $this->conn->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function registerUser($username, $email, $password, $phone) {
        $stmt = $this->conn->prepare('INSERT INTO users (username, email, password, phone_number, user_type) VALUES (:username, :email, :password, :phone, "customer")');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone', $phone);
        return $stmt->execute();
    }

    public function checkEmail($email) {
        $stmt = $this->conn->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateUser($username, $email, $password, $id) {
        $stmt = $this->conn->prepare('UPDATE users SET username = :username, email = :email, password = :password WHERE user_id = :id');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function countCustomersWithOrders() {
        $stmt = $this->conn->prepare("
            SELECT COUNT(DISTINCT users.user_id) AS customer_count
            FROM users
            JOIN orders ON users.user_id = orders.user_id
            WHERE users.user_type = 'customer'
        ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['customer_count'];
    }
}