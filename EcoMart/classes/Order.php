<?php

require_once 'Database.php';

class Order
{
    private $conn;
    private $table = 'orders';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function createOrder($user_id, $total_amount, $order_date, $shipping_address)
    {
        $sql = 'INSERT INTO ' . $this->table . ' 
                (user_id, total_amount, order_date, status, shipping_address) 
                VALUES (:user_id, :total_amount, :order_date, :status, :shipping_address)';

        $stmt = $this->conn->prepare($sql);

        $status = 'pending'; // Default status
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':order_date', $order_date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':shipping_address', $shipping_address);

        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function countUserOrders($user_id)
    {
        $sql = "SELECT COUNT(*) AS num_orders FROM " . $this->table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['num_orders'];
    }

    public function getOrderDetailsById($order_id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOrderShippingAddress($order_id, $shipping_address)
    {
        $sql = 'UPDATE ' . $this->table . ' SET shipping_address = :shipping_address WHERE order_id = :order_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':shipping_address', $shipping_address);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
    }

    public function updateOrderWithPayment($order_id, $payment_id)
    {
        $sql = 'UPDATE ' . $this->table . ' SET payment_id = :payment_id WHERE order_id = :order_id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':payment_id', $payment_id);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
    }

    public function getTotalSpentByUser($user_id)
    {
        $sql = "SELECT SUM(total_amount) AS total_spent FROM " . $this->table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_spent'];
    }

    public function getTotalAmountSum()
    {
        $sql = "SELECT SUM(total_amount) AS total_sum FROM " . $this->table;
        $stmt = $this->conn->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_sum'];
    }

    public function getOrdersBy($sort_order = 'ASC')
    {
        $sql = "SELECT orders.order_id, orders.user_id, orders.total_amount, orders.order_date, orders.status, 
                       orders.shipping_address, order_items.product_id, order_items.quantity, order_items.price 
                FROM " . $this->table . " 
                INNER JOIN order_items ON orders.order_id = order_items.order_id 
                ORDER BY orders.order_date $sort_order";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllOrdersByUserId($user_id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id ORDER BY order_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}