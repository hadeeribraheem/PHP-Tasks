<?php
include_once  './helpers/ConnectToDB.php';


function get_payment_details($order_id) {
    $conn = connectToDB();
    $data = $conn->query("SELECT * FROM payments WHERE order_id ='".$order_id."'");
    return $data->fetchAll();
}
function update_payment_details($order_id, $payment_method) {
    $conn = connectToDB();
    $sql = 'UPDATE payments SET payment_method = :payment_method WHERE order_id = :order_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':payment_method', $payment_method);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
}
function add_payment($order_id, $payment_method, $amount, $status) {
    $conn = connectToDB();
    $sql = 'INSERT INTO payments (order_id, payment_method, amount, status, payment_date) 
            VALUES (:order_id, :payment_method, :amount, :status, :payment_date)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->bindParam(':payment_method', $payment_method);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':status', $status);
    $date = date('Y-m-d H:i:s');
    $stmt->bindParam(':payment_date',$date ); // current date and time

    $stmt->execute();
    return $conn->lastInsertId(); // Return the payment ID
}

?>