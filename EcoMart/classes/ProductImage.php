<?php

require_once 'Database.php';

class ProductImage
{
    private $conn;
    private $table = 'product_images';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getProductImages($product_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveImageToProductImages($product_id, $image_url)
    {
        $query = "INSERT INTO " . $this->table . " (product_id, image_url) VALUES (:product_id, :image_url)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':image_url', $image_url);
        $stmt->execute();
    }

    public function uploadImages($product_id, $images)
    {
        $image_error = '';

        // Check if multiple files are uploaded
        if (is_array($images['name'])) {
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

                    $this->saveImageToProductImages($product_id, $image_url);
                }
            }
        } else {
            if (!empty($images['name'])) {
                $type = $images['type'];

                if (!(str_contains($type, 'image'))) {
                    $image_error = 'File uploaded is not an image';
                } else {
                    $image_tmp_name = $images['tmp_name'];
                    $image_url = 'uploads/' . $images['name'];
                    move_uploaded_file($image_tmp_name, $image_url);

                    $this->saveImageToProductImages($product_id, $image_url);
                }
            }
        }

        if ($image_error) {
            return $image_error;
        }

        return "Images uploaded successfully!";
    }
}
