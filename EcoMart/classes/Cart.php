<?php

require_once 'Database.php';
class Cart
{
    private $conn;
    private $table = 'cart';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getCartItem($user_id, $product_id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addToCart($user_id, $product_id, $quantity)
    {
        $sql = "INSERT INTO " . $this->table . " (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
    }

    public function getCartItems($user_id)
    {
        $sql = "SELECT c.*, p.product_id, p.name, p.price, p.image_url, p.stock_quantity 
                FROM " . $this->table . " c
                JOIN products p ON c.product_id = p.product_id
                WHERE c.user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCartItem($cart_id, $quantity)
    {
        $sql = "UPDATE " . $this->table . " SET quantity = :quantity WHERE cart_id = :cart_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':cart_id', $cart_id);
        $stmt->execute();
    }

    public function deleteCartItem($cart_id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE cart_id = :cart_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cart_id', $cart_id);
        $stmt->execute();
    }

    public function clearCart($user_id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }
}
