<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Produtos</title>
    <link rel="stylesheet" href="../css/catalogo.css">
    <style>
        /* Estilização básica para o layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #333;
            color: white;
        }

        header .logo img {
            width: 100px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-bar input {
            padding: 8px;
            width: 200px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .container {
            display: flex;
            padding: 20px;
        }

        aside {
            width: 20%;
        }

        aside ul {
            list-style: none;
            padding: 0;
        }

        aside ul li {
            margin-bottom: 10px;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .sidebar a:hover {
            color: #555;
        }

        main {
            width: 80%;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .product-card a {
            text-decoration: none;
            color: #333;
        }

        .product-card img {
            width: 100%;
            height: auto;
        }

        .product-name {
            font-size: 18px;
            margin-top: 10px;
        }

        .product-description {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        .product-price {
            margin-top: 15px;
            font-size: 16px;
            color: #e74c3c;
            font-weight: bold;
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

    <script>
        function displayProducts(products) {
            const productGrid = document.getElementById('product-grid');
            productGrid.innerHTML = '';

            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';

                productCard.innerHTML = `
                    <a href="../product/${product.id}">
                        <img src="../img/logoG.svg" alt="${product.name}" class="product-image">
                        <div class="product-name">${product.name}</div>
                        <div class="product-description">${product.description}</div>
                        <div class="product-price">R$ ${parseFloat(product.price).toFixed(2)}</div>
                    </a>
                `;
                productGrid.appendChild(productCard);
            });
        }

        function fetchProducts(filterType, filterValue) {
            const xhr = new XMLHttpRequest();
            const url = `/product/search`;
            xhr.open('GET', url, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    const products = JSON.parse(this.responseText);
                    displayProducts(products);
                }
            };
            xhr.send();
        }


        document.querySelectorAll('.category').forEach(categoryLink => {
            categoryLink.addEventListener('click', function(e) {
                e.preventDefault();
                const category = this.dataset.category;
                fetchProducts('filter', category);
            });
        });

        document.getElementById('search-btn').addEventListener('click', function() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            fetchProducts('search', searchInput);
        });

        fetchProducts('all', '');
    </script>
</body>

</html>