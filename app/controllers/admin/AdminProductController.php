<?php

namespace app\controllers\admin;

use app\database\models\ProductModel;
use app\controllers\BaseController;

class AdminProductController extends BaseController
{
    public function index()
    {
        $products = ProductModel::all();
        return $this->view('admin-products', ['products' => $products]);
    }

    public function create()
    {
        return $this->view('admin-create-products');
    }

    public function store()
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $info = $_POST['info'];
        $category = $_POST['category'];
        $estoque = $_POST['stock'];

        $success = ProductModel::create($name, $description, $price, $info, $category, $estoque);

        if ($success) {
            header('Location: /admin/products?success=Produto cadastrado com sucesso');
            return $this->view('admin-create-products');
        } else {
            return $this->view('admin-create-products', ['error' => 'Erro ao cadastrar produto']);
        }
    }

    public function edit($id)
    {
        $product = ProductModel::find($id);
        return $this->view('admin/products/edit', ['product' => $product]);
    }

    public function update($id)
    {
        $name = $_POST['nome'];
        $description = $_POST['descricao'];
        $price = $_POST['preco'];
        $info = $_POST['info'];
        $category = $_POST['categoria'];
        $estoque = $_POST['estoque'];

        $success = ProductModel::update($id, $name, $description, $price, $info, $category, $estoque);

        if ($success) {
            header('Location: /admin/products?success=Produto atualizado com sucesso');
        } else {
            return $this->view('admin/products/edit', ['error' => 'Erro ao atualizar produto']);
        }
    }

    public function delete($id)
    {
        $success = ProductModel::delete($id);

        if ($success) {
            header('Location: /admin/products?success=Produto excluído com sucesso');
        } else {
            header('Location: /admin/products?error=Erro ao excluir produto');
        }
    }
}
