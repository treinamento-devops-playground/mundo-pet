<?php

namespace app\database\models;

use PDO;
use app\database\Connection;

class CheckoutModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getConnection();
    }

    public function createCheckout($data)
    {
        $sql = "
            INSERT INTO checkout 
            (user_id, name, address, city, cep, complement, card_name, card_number, expiration_date, cvv, total_amount, discount, payment_status)
            VALUES 
            (:user_id, :name, :address, :city, :cep, :complement, :card_name, :card_number, :expiration_date, :cvv, :total_amount, :discount, :payment_status)
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':user_id' => $data['user_id'],
            ':name' => $data['name'],
            ':address' => $data['address'],
            ':city' => $data['city'],
            ':cep' => $data['cep'],
            ':complement' => $data['complement'],
            ':card_name' => $data['card_name'],
            ':card_number' => $data['card_number'],
            ':expiration_date' => $data['expiration_date'],
            ':cvv' => $data['cvv'],
            ':total_amount' => $data['total_amount'],
            ':discount' => $data['discount'] ?? 0,
            ':payment_status' => $data['payment_status']
        ]);
    }

    public function getCheckoutById($id)
    {
        $sql = "SELECT * FROM checkout WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllCheckouts()
    {
        $sql = "SELECT * FROM checkout";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
