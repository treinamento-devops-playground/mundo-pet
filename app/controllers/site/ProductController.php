<?php

namespace app\controllers\site;

use app\database\models\ProductModel;
use app\services\ReviewService;
use Exception;

class ProductController
{
    private $reviewService;

    public function __construct()
    {
        $this->reviewService = new ReviewService();
    }

    public function index()
    {
        try {
            $products = ProductModel::all();
            require_once __DIR__ . '/../../views/catalog.php';
        } catch (Exception $e) {
            die("Erro ao carregar os produtos: " . $e->getMessage());
        }
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
            $product = ProductModel::find($productId);

            if (!$product) {
                die("Produto não encontrado.");
            }

            $reviews = $this->reviewService->getProductReviews($productId);
            $totalReviews = count($reviews);
            $averageRating = 0;

            if ($totalReviews > 0) {
                $totalRating = array_sum(array_column($reviews, 'rating'));
                $averageRating = $totalRating / $totalReviews;
            }

            require_once __DIR__ . '/../../views/single-product.php';
        } catch (Exception $e) {
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
            $products = ProductModel::findByCategory($category);
            echo json_encode($products);
        } catch (Exception $e) {
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
            $products = ProductModel::search($query);
            echo json_encode($products);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Erro ao buscar produtos: ' . $e->getMessage()]);
        }
    }

    public function allProductsJson()
    {
        try {
            $products = ProductModel::all();
            echo json_encode($products);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Erro ao carregar os produtos: ' . $e->getMessage()]);
        }
    }

    public function addReview()
    {
        $reviewController = new ReviewController();
        $reviewController->addReview();
    }
}
