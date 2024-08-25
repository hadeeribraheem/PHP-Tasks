<?php
include_once  './helpers/ConnectToDB.php';


function create_order($user_id, $total_amount, $order_date, $shipping_address) {
    $conn = connectToDB();
    $sql = 'INSERT INTO orders (user_id, total_amount, order_date, status, shipping_address) VALUES (:user_id, :total_amount, :order_date, :status, :shipping_address)';

    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':total_amount', $total_amount);
    $stmt->bindParam(':order_date', $order_date);
    $status = 'pending'; // Set the status as pending
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':shipping_address', $shipping_address);

    $stmt->execute();
    return $conn->lastInsertId();

}

function count_user_orders($user_id) {
    $conn = connectToDB();
    $data = $conn->query("SELECT COUNT(*) AS num_orders FROM orders WHERE user_id = '".$user_id."'");
    return $data->fetch();
}
function get_order_details_by_id($order_id) {
    $conn = connectToDB();
    $data = $conn->query("SELECT * FROM orders WHERE order_id = '".$order_id."'");
    return $data->fetch();
}

function update_order_shipping_address($order_id, $shipping_address) {
    $conn = connectToDB();
    $sql = 'UPDATE orders SET shipping_address = :shipping_address WHERE order_id = :order_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':shipping_address', $shipping_address);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
}
function update_order_with_payment($order_id, $payment_id) {
    $conn = connectToDB();
    $sql = 'UPDATE orders 
            SET payment_id = :payment_id
            WHERE order_id = :order_id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':payment_id', $payment_id);
    $stmt->bindParam(':order_id', $order_id);

    $stmt->execute();
}

function get_total_spent_by_user($user_id) {
    $conn = connectToDB();
    $sql = "SELECT SUM(total_amount) AS total_spent FROM orders WHERE user_id = :user_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $result = $stmt->fetch();
    return $result['total_spent'];
}

function get_total_amount_sum() {
    $conn = connectToDB();
    $data = $conn->query("SELECT SUM(total_amount) AS total_sum FROM orders");
    $result=  $data->fetch();
    return $result['total_sum'];
}

function getOrdersBy($sort_order = 'ASC'){
    $conn = connectToDB();
    $data = $conn->query("SELECT orders.order_id, orders.user_id, orders.total_amount, orders.order_date, orders.status, 
                   orders.shipping_address, order_items.product_id, order_items.quantity, order_items.price 
            FROM orders 
            INNER JOIN order_items ON orders.order_id = order_items.order_id 
            ORDER BY orders.order_date $sort_order");
    return $data->fetchAll();
}


?>