<?php


require_once 'Database.php';
class Product
{
    private $conn;
    private $table = 'products';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllProducts($where = '')
    {
        $query = "SELECT * FROM " . $this->table . " " . $where;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll();
    }

    public function getProductsBy($sort_order = 'ASC')
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at $sort_order";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll();
    }

    public function getProductById($product_id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function addProduct($name, $description, $price, $stock_quantity, $category_id, $primary_image_url)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (name, description, price, stock_quantity, category_id, image_url) 
                  VALUES (:name, :description, :price, :stock_quantity, :category_id, :image_url)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock_quantity', $stock_quantity);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image_url', $primary_image_url);

        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function saveMainImageToProduct($product_id, $main_image_url)
    {
        $query = "UPDATE " . $this->table . " SET image_url = :image_url WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':image_url', $main_image_url);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
    }

    public function getCategories()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll();
    }
}
