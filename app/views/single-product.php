<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto</title>
    <link rel="stylesheet" href="../css/single-product.css">
    <style>
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

        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-details {
            display: flex;
            gap: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .product-image {
            width: 300px;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-info {
            max-width: 600px;
        }

        .product-name {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .product-description {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 20px;
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .product-category,
        .product-stock {
            font-size: 14px;
            color: #555;
        }

        .add-to-cart-btn {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-to-cart-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../img/logoG.svg" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="#">Serviços</a></li>
                <li><a href="#">Loja</a></li>
                <li><a href="#">Sobre</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <?php
        $dbFilePath = __DIR__ . '/../api/products.db';
        try {
            $pdo = new PDO('sqlite:' . $dbFilePath);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (isset($_GET['id'])) {
                $productId = $_GET['id'];

                // Busca o produto pelo ID fornecido
                $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
                $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    // Exibe os detalhes do produto
                    echo '<div class="product-details">';
                    echo '<img src="../img/logoG.svg" alt="' . htmlspecialchars($product['name']) . '" class="product-image">'; // Substitua por uma URL real da imagem do produto
                    echo '<div class="product-info">';
                    echo '<h1 class="product-name">' . htmlspecialchars($product['name']) . '</h1>';
                    echo '<p class="product-description">' . htmlspecialchars($product['description']) . '</p>';
                    echo '<p class="product-price">R$ ' . number_format($product['price'], 2, ',', '.') . '</p>';
                    echo '<p class="product-category">Categoria: ' . htmlspecialchars($product['category']) . '</p>';
                    echo '<p class="product-stock">Estoque: ' . htmlspecialchars($product['estoque']) . '</p>';
                    echo '<button class="add-to-cart-btn">Adicionar ao Carrinho</button>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo '<p>Produto não encontrado.</p>';
                }
            } else {
                echo '<p>ID do produto não especificado.</p>';
            }
        } catch (PDOException $e) {
            echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
            exit;
        }
        ?>
    </div>

</body>

</html>