<?php
require_once 'Database.php';

class Payment
{
    private $conn;
    private $table = 'payments';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getPaymentDetails($order_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePaymentDetails($order_id, $payment_method)
    {
        $query = "UPDATE " . $this->table . " SET payment_method = :payment_method WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payment_method', $payment_method);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
    }

    public function addPayment($order_id, $payment_method, $amount, $status)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (order_id, payment_method, amount, status, payment_date) 
                  VALUES (:order_id, :payment_method, :amount, :status, :payment_date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':payment_method', $payment_method);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':status', $status);
        $date = date('Y-m-d H:i:s');
        $stmt->bindParam(':payment_date', $date); // current date and time

        $stmt->execute();
        return $this->conn->lastInsertId(); // Return the payment ID
    }
}
