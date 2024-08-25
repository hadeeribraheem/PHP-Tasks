<?php

    include_once  './helpers/ConnectToDB.php';

    function get_products($where=''){
        $conn = connectToDB();
        $data = $conn -> query("SELECT * FROM products ".$where);
        return $data -> fetchAll();
    }
    function getProductsBy($sort_order = 'ASC'){
        $conn = connectToDB();
        $data = $conn -> query("SELECT * FROM products  ORDER BY created_at $sort_order");
        return $data -> fetchAll();
    }
    function get_product_by_id($product_id) {
        $conn = connectToDB();
        $data = $conn->query("SELECT * FROM products WHERE product_id ='".$product_id."'");
        return $data -> fetch();
    }

function addProduct($name, $description, $price, $stock_quantity, $category_id, $primary_image_url) {
    $conn = connectToDB();
    $sql = "INSERT INTO products (name, description, price, stock_quantity, category_id, image_url) VALUES (:name, :description, :price, :stock_quantity, :category_id, :image_url)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':stock_quantity', $stock_quantity);
    $stmt->bindParam(':category_id', $category_id); // Bind category ID
    $stmt->bindParam(':image_url', $primary_image_url); // Bind the primary image URL

    $stmt->execute();
    return $conn->lastInsertId();
}


//bug
function uploadImages($product_id, $images) {
    $conn = connectToDB();
    $image_error = '';

    // Check if multiple files are uploaded
    if (is_array($images['name'])) {
        // Handle multiple files
        foreach ($images['name'] as $key => $image_name) {
            if (!empty($image_name)) {
                $type = $images['type'][$key];

                // Check if the uploaded file is an image
                if (!(str_contains($type, 'image'))) {
                    $image_error = 'File uploaded is not an image';
                    break;
                }

                $image_tmp_name = $images['tmp_name'][$key];
                $image_url = 'uploads/' . $image_name;
                move_uploaded_file($image_tmp_name, $image_url);

                // Insert image data into the product_images table
                $sql = "INSERT INTO product_images (product_id, image_url) VALUES (:product_id, :image_url)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':image_url', $image_url);
                $stmt->execute();
            }
        }
    } else {
        // Handle a single file
        if (!empty($images['name'])) {
            $type = $images['type'];

            // Check if the uploaded file is an image
            if (!(str_contains($type, 'image'))) {
                $image_error = 'File uploaded is not an image';
            } else {
                $image_tmp_name = $images['tmp_name'];
                $image_url = 'uploads/' . $images['name'];
                move_uploaded_file($image_tmp_name, $image_url);

                // Insert image data into the product_images table
                $sql = "INSERT INTO product_images (product_id, image_url) VALUES (:product_id, :image_url)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':image_url', $image_url);
                $stmt->execute();
            }
        }
    }

    if ($image_error) {
        return $image_error;
    }

    return "Images uploaded successfully!";
}

    function getCategories()
    {
        $conn = connectToDB();
        $data = $conn -> query("SELECT * FROM categories");
        return $data -> fetchAll();
    }
function saveMainImageToProduct($product_id, $main_image_url) {
    $conn = connectToDB();
    $sql = "UPDATE products SET image_url = :image_url WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':image_url', $main_image_url);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
}
?>