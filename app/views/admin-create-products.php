<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
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
            <h1>Adicionar Novo Produto</h1>

            <?php if (isset($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form action="/admin/products/store" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" required>

                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" required></textarea>

                <label for="preco">Preço:</label>
                <input type="text" name="preco" id="preco" required>

                <label for="info">Informações Adicionais:</label>
                <input type="text" name="info" id="info">

                <label for="categoria">Categoria:</label>
                <input type="text" name="categoria" id="categoria" required>

                <label for="estoque">Estoque:</label>
                <input type="number" name="estoque" id="estoque" required>

                <button type="submit" class="btn">Salvar Produto</button>
            </form>
        </div>
    </main>
</body>

</html>