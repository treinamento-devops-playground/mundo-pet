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
        header('Content-Type: application/json');
        $products = $this->productService->getAllProducts();
        echo json_encode($products);
        exit();
    }

    public function filterByCategoryJson()
    {
        header('Content-Type: application/json');
        $category = $_GET['category'] ?? '';
        $products = $this->productService->getProductsByCategory($category);
        echo json_encode($products);
        exit();
    }

    public function searchJson()
    {
        header('Content-Type: application/json');
        $searchTerm = $_GET['search'] ?? '';
        $products = $this->productService->searchProducts($searchTerm);
        echo json_encode($products);
        exit();
    }

    public function show($id)
    {
        $product = $this->productService->getProductById((int)$id);
        if (!$product) {
            return $this->view('single-product', ['error' => 'Produto não encontrado']);
        }
        return $this->view('single-product', ['product' => $product]);
    }
}
