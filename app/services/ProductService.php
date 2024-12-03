<?php

namespace app\services;

use app\database\models\ProductModel;

class ProductService
{
    public function getAllProducts(): array
    {
        return ProductModel::all();
    }

    public function getProductsByCategory(string $category): array
    {
        return ProductModel::findByCategory($category);
    }

    public function searchProducts(string $searchTerm): array
    {
        return ProductModel::search($searchTerm);
    }

    public function getProductById(int $id): ?array
    {
        return ProductModel::find($id);
    }
}
