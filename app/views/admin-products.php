<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Produtos</title>
    <link rel="stylesheet" href="/css/adminProdutos.css">
</head>

<body>
    <header>
        <nav id="nav-bar">
            <div class="logo">
                <img src="/img/logo.png" alt="Logo Mundo Pet">
            </div>
            <ul class="list-nav">
                <li><a href="/admin">Painel</a></li>
                <li><a href="/admin/products">Produtos</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </nav>
    </header>

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
                            <td><?php echo htmlspecialchars($product['estoque']); ?></td>
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

</html>