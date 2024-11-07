<?php

namespace app\database\models;

use app\database\Connection;
use PDO;

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getConnection();
    }

    public function getAdminPassword()
    {
        return password_hash('12345678', PASSWORD_DEFAULT);
    }

    public function getUserByEmail(string $email)
    {
        $stmt = $this->db->prepare("SELECT id, email, password FROM users WHERE email = :email");
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . implode(", ", $this->db->errorInfo()));
        }
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser(string $username, string $email, string $password, string $phone)
    {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, phone) VALUES (:username, :email, :password, :phone)");
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . implode(", ", $this->db->errorInfo()));
        }
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getUsernameById(int $userId)
    {
        $stmt = $this->db->prepare("SELECT username FROM users WHERE id = :id");
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . implode(", ", $this->db->errorInfo()));
        }
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['username'] ?? '';
    }

    public function getUserById(int $userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . implode(", ", $this->db->errorInfo()));
        }
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser(int $userId, array $data)
    {
        $stmt = $this->db->prepare("UPDATE users SET username = :username, email = :email, phone = :phone, city = :city, state = :state, street = :street, postal_code = :postal_code, number = :number, complement = :complement WHERE id = :id");
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . implode(", ", $this->db->errorInfo()));
        }
        $stmt->bindValue(':username', $data['username'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':phone', $data['phone'], PDO::PARAM_STR);
        $stmt->bindValue(':city', $data['city'], PDO::PARAM_STR);
        $stmt->bindValue(':state', $data['state'], PDO::PARAM_STR);
        $stmt->bindValue(':street', $data['street'], PDO::PARAM_STR);
        $stmt->bindValue(':postal_code', $data['postal_code'], PDO::PARAM_STR);
        $stmt->bindValue(':number', $data['number'], PDO::PARAM_INT);
        $stmt->bindValue(':complement', $data['complement'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
