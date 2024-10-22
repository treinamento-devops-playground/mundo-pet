<?php

namespace app\controllers\site;

use app\database\models\ProductModel;
use app\controllers\BaseController;

class ProductController extends BaseController
{
    public function index()
    {
        $products = ProductModel::all();
        return $this->view('catalog', ['products' => $products]);
    }

    public function filterByCategoryJson()
    {
        $category = $_GET['category'] ?? '';
        $products = ProductModel::findByCategory($category);
        return $this->json($products);
    }

    public function searchJson()
    {
        $searchTerm = $_GET['search'] ?? '';
        $products = ProductModel::search($searchTerm);
        return $this->json($products);
    }

    private function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
