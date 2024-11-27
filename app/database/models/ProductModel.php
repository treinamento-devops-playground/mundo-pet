<?php

namespace app\database\models;

use PDO;
use app\database\Connection;

class ProductModel
{
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
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function search($searchTerm)
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :searchTerm OR description LIKE :searchTerm");
        $term = "%" . $searchTerm . "%";
        $stmt->bindParam(':searchTerm', $term, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
