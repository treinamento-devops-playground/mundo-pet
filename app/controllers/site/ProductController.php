<?php

namespace app\controllers\site;

use app\database\Connection;
use app\database\models\ProductModel;
use app\services\ReviewService;
use Exception;
use PDO;

class ProductController
{
    private $reviewService;

    public function __construct()
    {
        $this->reviewService = new ReviewService();
    }

    public function index()
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../views/catalog.php';
    }

    public function show()
    {
        $requestUri = $_SERVER['REQUEST_URI'];

        if (preg_match('/\/product\/(\d+)$/', $requestUri, $matches)) {
            $productId = intval($matches[1]);
        } else {
            die("ID do produto não especificado.");
        }

        try {
            $pdo = Connection::getConnection();

            $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
            $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                die("Produto não encontrado.");
            }

            $reviewsStmt = $pdo->prepare('SELECT * FROM review WHERE product_id = :product_id');
            $reviewsStmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $reviewsStmt->execute();
            $reviews = $reviewsStmt->fetchAll(PDO::FETCH_ASSOC);

            $totalReviews = count($reviews);
            $averageRating = 0;

            if ($totalReviews > 0) {
                $totalRating = 0;
                foreach ($reviews as $review) {
                    $totalRating += $review['rating'];
                }
                $averageRating = $totalRating / $totalReviews;
            }

            require_once __DIR__ . '/../../views/single-product.php';
        } catch (\PDOException $e) {
            die("Erro ao carregar o produto: " . $e->getMessage());
        }
    }

    public function filterByCategoryJson()
    {
        $category = $_GET['category'] ?? null;

        if (!$category) {
            echo json_encode(['error' => 'Categoria não especificada.']);
            return;
        }

        try {
            $pdo = Connection::getConnection();

            $stmt = $pdo->prepare('SELECT * FROM products WHERE category = :category');
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->execute();

            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($products);
        } catch (\PDOException $e) {
            echo json_encode(['error' => 'Erro ao filtrar produtos: ' . $e->getMessage()]);
        }
    }

    public function searchJson()
    {
        $query = $_GET['query'] ?? null;

        if (!$query) {
            echo json_encode(['error' => 'Consulta de busca não especificada.']);
            return;
        }

        try {
            $pdo = Connection::getConnection();

            $stmt = $pdo->prepare('SELECT * FROM products WHERE name LIKE :query OR description LIKE :query');
            $query = "%$query%";
            $stmt->bindParam(':query', $query, PDO::PARAM_STR);
            $stmt->execute();

            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($products);
        } catch (\PDOException $e) {
            echo json_encode(['error' => 'Erro ao buscar produtos: ' . $e->getMessage()]);
        }
    }

    public function allProductsJson()
    {
        try {
            $pdo = Connection::getConnection();

            $stmt = $pdo->query('SELECT * FROM products');
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($products);
        } catch (\PDOException $e) {
            echo json_encode(['error' => 'Erro ao carregar os produtos: ' . $e->getMessage()]);
        }
    }
   
    public function addReview()
    {
        $reviewController = new ReviewController();
        $reviewController->addReview();
    }
}
