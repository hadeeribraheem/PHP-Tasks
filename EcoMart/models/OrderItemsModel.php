<?php

include_once  './helpers/ConnectToDB.php';

function add_order_item($order_id, $product_id, $quantity, $price) {
    $conn = connectToDB();
    $sql = 'INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':price', $price);
    $stmt->execute();
}
function get_orders() {
    $conn = connectToDB();
    $data = $conn->query('SELECT * FROM order_items');
    return $data->fetchAll();

}

function get_order_items($order_id) {
    $conn = connectToDB();
    $sql = 'SELECT order_items.*, products.name 
            FROM order_items 
            JOIN products ON order_items.product_id = products.product_id 
            WHERE order_items.order_id = :order_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
    return $stmt->fetchAll();
}



?>