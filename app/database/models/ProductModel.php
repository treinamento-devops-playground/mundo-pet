<?php

namespace app\database\models;

use PDO;
use app\database\Connection;

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    public static function all()
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByCategory($category)
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category = :category");
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function search($searchTerm)
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :searchTerm OR description LIKE :searchTerm");
        $term = "%" . $searchTerm . "%";
        $stmt->bindParam(':searchTerm', $term);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($name, $description, $price, $info, $category, $stock)
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO products (name, description, price, info, category, stock)
            VALUES (:name, :description, :price, :info, :category, :stock)
        ");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':info', $info);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':stock', $stock);

        return $stmt->execute();
    }

    public static function find($id)
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        error_log("Consultando produto com ID: " . $id);

        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            error_log("Produto não encontrado para ID: " . $id);
        }

        return $product;
    }


    public static function update($id, $name, $description, $price, $info, $category, $stock)
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("
            UPDATE products
            SET name = :name, description = :description, price = :price, info = :info, category = :category, stock = :stock
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':info', $info);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':stock', $stock);

        return $stmt->execute();
    }

    public static function delete($id)
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
