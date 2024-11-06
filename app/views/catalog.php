<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Produtos</title>
    <link rel="stylesheet" href="../css/catalogo.css">
    <style>
        .sidebar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            display: block;
            padding: 2px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar a:hover {
            background-color: #f0f0f0;
            color: #555;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../img/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="#">Serviços</a></li>
                <li><a href="#">Loja</a></li>
                <li><a href="#">Sobre</a></li>
            </ul>
        </nav>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Pesquisar produtos...">
            <button id="search-btn">Pesquisar</button>
        </div>
    </header>

    <div class="container">
        <aside>
            <ul class="sidebar">
                <li><a href="#" class="category" data-category="petiscos">Petiscos</a></li>
                <li><a href="#" class="category" data-category="brinquedos">Brinquedos</a></li>
                <li><a href="#" class="category" data-category="acessorios">Acessórios</a></li>
            </ul>
        </aside>

        <main>
            <div class="product-grid" id="product-grid">

            </div>
        </main>
    </div>

    <script src="../js/catalog.js"></script>
</body>

</html>