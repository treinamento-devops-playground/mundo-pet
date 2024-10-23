<?php
$requestUri = $_SERVER['REQUEST_URI'];

if (preg_match('/\/product\/(\d+)$/', $requestUri, $matches)) {
    $productId = intval($matches[1]);
} else {
    die("ID do produto não especificado.");
}

try {
    $dbPath = __DIR__ . '/../database/db.db';
    $dsn = 'sqlite:' . $dbPath;
    $pdo = new PDO($dsn);

    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Produto não encontrado.");
    }
} catch (PDOException $e) {
    die("Não foi possível conectar ao banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Catálogo de Produtos</title>
    <link rel="stylesheet" href="../css/catalogo.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
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
            width: 120px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #FF9900;
        }

        .container {
            display: flex;
            padding: 40px;
            justify-content: center;
            max-width: 1200px;
            margin: auto;
        }

        .product-details {
            max-width: 600px;
            text-align: center;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s;
        }

        .product-details:hover {
            transform: scale(1.02);
        }

        .product-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
        }

        .product-name {
            font-size: 28px;
            margin: 10px 0;
            font-weight: bold;
        }

        .product-description {
            font-size: 16px;
            color: #666;
            margin: 10px 0;
            line-height: 1.5;
        }

        .product-price {
            font-size: 22px;
            color: #B12704;
            font-weight: bold;
            margin: 20px 0;
        }

        .product-stock {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        .back-link {
            text-decoration: none;
            color: #0073BB;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #005B8C;
        }

        .add-to-cart-btn {
            text-decoration: none;
            background-color: #FF9900;
            color: white;
            padding: 12px 24px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .add-to-cart-btn:hover {
            background-color: #E68A00;
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
    </header>

    <div class="container">
        <div class="product-details">
            <img src="../img/logoG.svg" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
            <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
            <div class="product-description">Descrição: <?php echo htmlspecialchars($product['description']); ?></div>
            <div class="product-price">R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></div>
            <div class="product-stock">Estoque: <?php echo htmlspecialchars($product['stock']); ?></div>

            <form action="/cart/add" method="POST">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                <button type="submit" class="add-to-cart-btn">Adicionar ao Carrinho</button>
            </form>
        </div>
    </div>

    <a href="/product" class="back-link">Voltar ao Catálogo</a>
</body>

</html>