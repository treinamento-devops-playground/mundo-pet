<?php

namespace app\models;

use PDO;
use PDOException;

class Agendamento
{
    private static function getConnection()
    {
        try {
            $pdo = new PDO('sqlite:' . __DIR__ . '/../db/db.db');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
        }
    }
    public static function create($userId, $petType, $serviceType, $date, $time)
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare('INSERT INTO agendamentos (user_id, pet_type, service_type, date, time) 
                               VALUES (:user_id, :pet_type, :service_type, :date, :time)');
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':pet_type', $petType);
        $stmt->bindParam(':service_type', $serviceType);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        return $stmt->execute();
    }

    public static function isAvailable($userId, $date, $time, $serviceType)
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM agendamentos WHERE user_id = :user_id AND date = :date AND time = :time AND service_type = :service_type');
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':service_type', $serviceType);
        $stmt->execute();

        return $stmt->rowCount() === 0;
    }

    public static function find($id)
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM agendamentos WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $data)
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare('UPDATE agendamentos SET pet_type = :pet_type, service_type = :service_type, date = :date, time = :time WHERE id = :id');
        $stmt->bindParam(':pet_type', $data['pet_type']);
        $stmt->bindParam(':service_type', $data['service_type']);
        $stmt->bindParam(':date', $data['date']);
        $stmt->bindParam(':time', $data['time']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
