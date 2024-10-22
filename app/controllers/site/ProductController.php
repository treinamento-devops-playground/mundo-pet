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
    public function show($id)
    {
        // Debug: exibir o ID do produto
        error_log("ID do produto: " . $id);

        $product = ProductModel::find($id);

        // Debug: verificar se o produto foi encontrado
        if (!$product) {
            error_log("Produto não encontrado para ID: " . $id);
            return $this->view('single-product', ['error' => 'Produto não encontrado']);
        }

        // Retorna a view com o produto encontrado
        return $this->view('single-product', ['product' => $product]);
    }


    private function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}
