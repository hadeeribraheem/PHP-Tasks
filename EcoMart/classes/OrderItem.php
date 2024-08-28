<?php


require_once 'Database.php';

class OrderItem
{
    private $conn;
    private $table = 'order_items';
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function addOrderItem($order_id, $product_id, $quantity, $price)
    {
        $sql = 'INSERT INTO ' . $this->table . ' (order_id, product_id, quantity, price) 
                VALUES (:order_id, :product_id, :quantity, :price)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->execute();
    }

    public function getAllOrderItems()
    {
        $sql = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function getOrderItemsByOrderId($order_id)
    {
        $sql = 'SELECT oi.*, p.name, p.image_url 
                FROM ' . $this->table . ' oi 
                JOIN products p ON oi.product_id = p.product_id 
                WHERE oi.order_id = :order_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // New method to get all orders by user
    public function getAllOrdersByUserId($user_id)
    {
        $sql = 'SELECT orders.*, order_items.*, products.name 
                FROM orders 
                JOIN order_items ON orders.order_id = order_items.order_id 
                JOIN products ON order_items.product_id = products.product_id 
                WHERE orders.user_id = :user_id
                ORDER BY orders.order_date DESC';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}