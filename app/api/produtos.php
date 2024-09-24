<?php
class Database
{
    private $pdo;

    public function __construct($dbFilePath)
    {
        $this->connect($dbFilePath);
    }

    private function connect($dbFilePath)
    {
        try {
            $this->pdo = new PDO('sqlite:' . $dbFilePath);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}

class ProductTable
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            price NUMERIC(10, 2) NOT NULL,
            info VARCHAR(255),
            category VARCHAR(50),
            estoque INTEGER NOT NULL
        )";
        $this->pdo->exec($sql);
    }

    public function insertProduct($name, $description, $price, $info, $category, $estoque)
    {
        try {
            $sql = "INSERT INTO products (name, description, price, info, category, estoque) 
                    VALUES (:name, :description, :price, :info, :category, :estoque)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':info', $info);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':estoque', $estoque);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar produto: " . $e->getMessage();
            return false;
        }
    }
}

class ProductController
{
    private $productTable;

    public function __construct($dbFilePath)
    {
        $database = new Database($dbFilePath);
        $this->productTable = new ProductTable($database->getPdo());
        $this->productTable->createTable();
    }

    public function handleRequest()
    {
        if (isset($_POST['nome'])) {
            $name = $_POST['nome'];
            $info = $_POST['info'];
            $price = $_POST['preco'];
            $estoque = $_POST['estoque'];
            $category = $_POST['categoria'];
            $description = $_POST['descricao'];

            if ($this->productTable->insertProduct($name, $description, $price, $info, $category, $estoque)) {
                echo "Produto cadastrado com sucesso";
            } else {
                echo "Erro ao cadastrar produto";
            }
        }
    }
}

$dbFilePath = __DIR__ . '/products.db'; // Caminho absoluto para products.db
$productController = new ProductController($dbFilePath);
$productController->handleRequest();