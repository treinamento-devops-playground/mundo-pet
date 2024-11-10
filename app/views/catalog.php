<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Produtos</title>
    <link rel="stylesheet" href="../css/catalogo.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="../img/logo.png" alt="Logo">
        </div>
        <ul class="list-nav">
            <li class="title"><a href="/services">Serviços</a></li>
            <li class="title"><a href="product">Loja</a></li>
            <li class="title"><a href="#">Contato</a></li>
            <li><a href="/vis_agen"><img src="../img/icons/user.png" alt="Usuário"></a></li>
            <li><a href="/vcart"><img src="../img/icons/cart.png" alt="Carrinho"></a></li> 
            </ul>
    
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Pesquisar produtos...">
            <button id="search-btn">
                <img src="../img/icons/lupa.png" alt="Pesquisar" class="search-icon">
            </button>
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
