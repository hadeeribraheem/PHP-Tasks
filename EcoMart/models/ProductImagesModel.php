<?php
include_once  './helpers/ConnectToDB.php';
function get_product_images($product_id){
    $conn = connectToDB();
    $data = $conn -> query("SELECT * FROM product_images WHERE product_id = '".$product_id."'");
    return $data -> fetchAll();
}

function saveImageToProductImages($product_id, $image_url) {
    $conn = connectToDB();
    $sql = "INSERT INTO product_images (product_id, image_url) VALUES (:product_id, :image_url)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':image_url', $image_url);
    $stmt->execute();
}
?>