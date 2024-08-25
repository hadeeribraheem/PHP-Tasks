<?php

include_once  './helpers/ConnectToDB.php';
function get_cart_item($user_id, $product_id) {
    $conn = connectToDB();
    $data = $conn->query("SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id");
    return $data->fetch();

}

function add_to_cart($user_id, $product_id, $quantity) {
    $conn = connectToDB();
    $sql='INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id',$user_id);
    $stmt->bindParam(':product_id',$product_id);
    $stmt->bindParam(':quantity',$quantity);
    $stmt->execute();
}

function get_cart_items($user_id) {
    $conn = connectToDB();
    $data = $conn->query("SELECT cart.* , products.product_id , products.name, products.price, products.image_url, products.stock_quantity 
                          FROM cart
                          JOIN products ON cart.product_id = products.product_id
                          WHERE cart.user_id = '".$user_id."'");
    return $data->fetchAll();
}


function update_cart_item($cart_id, $quantity) {
    $conn = connectToDB();
    $conn->query("UPDATE cart SET quantity = $quantity WHERE cart_id = $cart_id");
}

function delete_cart_item($cart_id) {
    $conn = connectToDB();
    $conn->query("DELETE FROM cart WHERE cart_id = $cart_id");
}
function clear_cart($user_id) {
    $conn = connectToDB();
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}



?>

