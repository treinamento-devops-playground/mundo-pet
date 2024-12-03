<?php $this->layout('admin-base', ['title' => 'Adicionar Produto']); ?>

<?php $this->start('css'); ?>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    #nav-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #6B6EAF;
        padding: 10px 20px;
    }

    .logo img {
        max-width: 150px;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #333;
        text-align: center;
    }

    .success,
    .error {
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        margin: 20px 0;
    }

    .success {
        background-color: #d4edda;
        color: #155724;
    }

    .error {
        background-color: #f8d7da;
        color: #721c24;
    }

    .btn {
        display: inline-block;
        padding: 10px 15px;
        margin: 10px 0;
        background-color: #6B6EAF;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #5a5d8b;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
        cursor: pointer;
        padding: 10px 15px;
        border-radius: 5px;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
</style>
<?php $this->stop(); ?>

<?php $this->start('admin-content'); ?>

<body>

    <main>
        <div class="container">
            <h1>Lista de Produtos</h1>

            <?php if (isset($_GET['success'])): ?>
                <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>

            <a href="/admin/products/create" class="btn">Adicionar Novo Produto</a>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Estoque</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td>R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($product['category']); ?></td>
                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            <td>
                                <a href="/admin/products/edit/<?php echo $product['id']; ?>" class="btn">Editar</a>
                                <form action="/admin/products/delete/<?php echo $product['id']; ?>" method="POST" style="display:inline;">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
<?php $this->stop(); ?>