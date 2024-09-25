<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto</title>
    <link rel="stylesheet" href="../css/single-product.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="../img/logo.png" alt="Logo">
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

                $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
                $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    echo '<div class="product-details">';
                    echo '<img src="../img/logo.png" alt="' . htmlspecialchars($product['name']) . '" class="product-image">';
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