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
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Pesquisar produtos...">
            <button onclick="searchProducts()">Pesquisar</button>
        </div>
    </header>

    <div class="container">
        <aside>
            <ul class="sidebar">
                <li><a href="#" onclick="filterProducts('petiscos')">Petiscos</a></li>
                <li><a href="#" onclick="filterProducts('brinquedos')">Brinquedos</a></li>
                <li><a href="#" onclick="filterProducts('acessorios')">Acessórios</a></li>
            </ul>
        </aside>

        <main>
            <div class="product-grid" id="product-grid">
            </div>
        </main>
    </div>

    <?php
    $dbFilePath = 'api/products.db';
    try {
        $pdo = new PDO('sqlite:' . $dbFilePath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
        exit;
    }
    ?>

    <script>
        const products = <?php echo json_encode($products); ?>;

        function getRandomImage() {
            const images = [
                '../img/logo.png',
            ];
            return images[Math.floor(Math.random() * images.length)];
        }

        // Função para exibir os produtos como cards
        function displayProducts(filteredProducts) {
            const productGrid = document.getElementById('product-grid');
            productGrid.innerHTML = ''; // Limpar o grid antes de exibir os produtos

            filteredProducts.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';

                productCard.innerHTML = `
                    <a href="single-product.php?id=${product.id}">
                        <img src="${getRandomImage()}" alt="${product.name}" class="product-image">
                        <div class="product-name">${product.name}</div>
                        <div class="product-description">${product.description}</div>
                        <div class="product-price">R$ ${parseFloat(product.price).toFixed(2)}</div>
                    </a>
                `;
                productGrid.appendChild(productCard);
            });
        }

        function filterProducts(category) {
            const filteredProducts = products.filter(product => product.category === category);
            displayProducts(filteredProducts);
        }

        function searchProducts() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const filteredProducts = products.filter(product =>
                product.name.toLowerCase().includes(searchInput) ||
                product.description.toLowerCase().includes(searchInput)
            );
            displayProducts(filteredProducts);
        }
        displayProducts(products);
    </script>

</body>

</html>