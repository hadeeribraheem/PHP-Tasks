<?php

require_once 'Database.php';
class Shipping
{
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getShippingDetails($orderId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM shipping WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateShippingDetails($orderId, $shippingMethod)
    {
        $stmt = $this->conn->prepare("UPDATE shipping SET shipping_method = :shipping_method WHERE order_id = :order_id");
        $stmt->bindParam(':shipping_method', $shippingMethod);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
    }

    public function addShipping($orderId, $shippingMethod, $shippingCost, $shippingDate, $deliveryDate)
    {
        $stmt = $this->conn->prepare("INSERT INTO shipping (order_id, shipping_method, shipping_cost, shipping_date, delivery_date) 
                                      VALUES (:order_id, :shipping_method, :shipping_cost, :shipping_date, :delivery_date)");
        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':shipping_method', $shippingMethod);
        $stmt->bindParam(':shipping_cost', $shippingCost);
        $stmt->bindParam(':shipping_date', $shippingDate);
        $stmt->bindParam(':delivery_date', $deliveryDate);
        $stmt->execute();

        return $this->conn->lastInsertId();
    }
}