<?php

namespace app\database;

use PDO;
use PDOException;

class Connection
{
    private static $pdo;

    public static function getConnection()
    {
        if (!self::$pdo) {
            try {
                $databasePath = __DIR__ . '/db.db';
                self::$pdo = new PDO('sqlite:' . $databasePath);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }

    public static function createDatabase()
    {
        $dbFile = __DIR__ . '/db.db';

        if (!file_exists($dbFile)) {
            $pdo = self::getConnection();

            $schedulingTable = "
                CREATE TABLE IF NOT EXISTS scheduling (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    user_id INTEGER NOT NULL,
                    pet_type TEXT NOT NULL,
                    service_type TEXT NOT NULL,
                    date TEXT NOT NULL,
                    time TEXT NOT NULL
                );
            ";

            $usersTable = "
                CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    username TEXT NOT NULL,
                    email TEXT NOT NULL UNIQUE,
                    password TEXT NOT NULL,
                    phone TEXT NOT NULL
                );
            ";

            $productsTable = "
                CREATE TABLE IF NOT EXISTS products (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    price REAL NOT NULL,
                    description TEXT,
                    info TEXT,
                    category TEXT,
                    stock INTEGER NOT NULL DEFAULT 0
                );
            ";

            $cartsTable = "
                CREATE TABLE IF NOT EXISTS cart (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    user_id INTEGER NOT NULL,
                    product_id INTEGER NOT NULL,
                    quantity INTEGER NOT NULL DEFAULT 1,
                    FOREIGN KEY (user_id) REFERENCES users(id),
                    FOREIGN KEY (product_id) REFERENCES products(id)
                );
            ";

            try {
                $pdo->exec($schedulingTable);
                $pdo->exec($usersTable);
                $pdo->exec($productsTable);
                $pdo->exec($cartsTable);
                echo "Banco de dados e tabelas criados com sucesso.";
            } catch (PDOException $e) {
                die('Erro ao criar tabelas: ' . $e->getMessage());
            }
        }
    }
}
