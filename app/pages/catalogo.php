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
        <nav>
            <ul>
                <li><a href="#">Serviços</a></li>
                <li><a href="#">Loja</a></li>
                <li><a href="#">Sobre</a></li>
            </ul>
        </nav>
        <div class="menu-icon">
            <img src="menu-icon.png" alt="Menu">
        </div>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Pesquisar produtos...">
            <button onclick="searchProducts()">Pesquisar</button>
        </div>
    </header>

    <div class="container">
        <aside>
            <ul class="sidebar">
                <li><a href="#" onclick="filterProducts('ração')">Ração</a></li>
                <li><a href="#" onclick="filterProducts('remédios')">Remédios</a></li>
                <li><a href="#" onclick="filterProducts('produtos')">Produtos</a></li>
            </ul>
        </aside>

        <main>

            <div class="product-grid" id="product-grid">
            </div>
        </main>
    </div>

    <script>
        const products = [{
                name: 'Produto 1',
                category: 'ração',
                color: 'green'
            },
            {
                name: 'Produto 2',
                category: 'remédios',
                color: 'purple'
            },
            {
                name: 'Produto 3',
                category: 'produtos',
                color: 'green'
            },
            {
                name: 'Produto 3',
                category: 'ração',
                color: 'green'
            },
            {
                name: 'Produto 4',
                category: 'remédios',
                color: 'purple'
            },
            {
                name: 'Produto 5',
                category: 'produtos',
                color: 'green'
            },
        ];

        let currentCategory = '';

        function displayProducts(filteredProducts) {
            const productGrid = document.getElementById('product-grid');
            productGrid.innerHTML = '';
            filteredProducts.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = `product-card ${product.color}`;
                productCard.innerHTML = `<div class="product-name">${product.name}</div>`;
                productGrid.appendChild(productCard);
            });
        }

        function filterProducts(category) {
            currentCategory = category;
            const filteredProducts = products.filter(product => product.category === category);
            displayProducts(filteredProducts);
        }

        function searchProducts() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const filteredProducts = products.filter(product =>
                product.name.toLowerCase().includes(searchInput)
            );
            const uniqueProducts = Array.from(new Set(filteredProducts.map(p => p.name)))
                .map(name => {
                    return filteredProducts.find(p => p.name === name);
                });
            displayProducts(uniqueProducts);
        }

        // Exibir todos os produtos inicialmente
        displayProducts(products);
    </script>
</body>

</html>