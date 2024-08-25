<?php
include_once  './helpers/ConnectToDB.php';


function get_shipping_details($order_id) {
    $conn = connectToDB();
    $data = $conn->query("SELECT * FROM shipping WHERE order_id ='".$order_id."'");
    return $data->fetchAll();
}
function update_shipping_details($order_id, $shipping_method) {
    $conn = connectToDB();
    $sql = 'UPDATE shipping SET shipping_method = :shipping_method WHERE order_id = :order_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':shipping_method', $shipping_method);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
}
function add_shipping($order_id, $shipping_method, $shipping_cost, $shipping_date, $delivery_date) {
    $conn = connectToDB();
    $sql = 'INSERT INTO shipping (order_id, shipping_method, shipping_cost, shipping_date, delivery_date ) 
            VALUES (:order_id, :shipping_method, :shipping_cost, :shipping_date, :delivery_date)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->bindParam(':shipping_method', $shipping_method);
    $stmt->bindParam(':shipping_cost', $shipping_cost);
    $stmt->bindParam(':shipping_date', $shipping_date);
    $stmt->bindParam(':delivery_date', $delivery_date);

    $stmt->execute();

    return $conn->lastInsertId();  // return the ID of the inserted shipping record
}

?>