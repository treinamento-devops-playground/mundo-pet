<?php

namespace app\controllers\site;

use app\controllers\BaseController;
use app\services\ProductService;

class ProductController extends BaseController
{
    private ProductService $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index()
    {
        return $this->view('catalog');
    }

    public function allProductsJson()
    {
        $products = $this->productService->getAllProducts();
        return $this->jsonResponse($products);
    }

    public function filterByCategoryJson()
    {
        $category = $_GET['category'] ?? '';
        $products = $this->productService->getProductsByCategory($category);
        return $this->jsonResponse($products);
    }

    public function searchJson()
    {

        $searchTerm = $_GET['search'] ?? '';
        $products = $this->productService->searchProducts($searchTerm);
        return $this->jsonResponse($products);
    }

    public function show($id)
    {
        $product = $this->productService->getProductById((int)$id);
        if (!$product) {
            return $this->view('single-product', ['error' => 'Produto não encontrado']);
        }
        return $this->view('single-product', ['product' => $product]);
    }

    private function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
