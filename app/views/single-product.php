<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Produtos</title>
    <link rel="stylesheet" href="../css/catalogo.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .product-detail {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .product-detail h1 {
            color: #333;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .product-detail h2 {
            color: #555;
            font-size: 1.5em;
            margin: 15px 0 5px;
        }

        .product-description p,
        .product-info ul {
            font-size: 1em;
            line-height: 1.6;
            color: #666;
        }

        .product-info ul {
            list-style-type: none;
            padding: 0;
        }

        .product-info li {
            margin-bottom: 5px;
        }

        .product-additional-info p {
            margin: 10px 0;
        }

        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            font-size: 1.2em;
            text-align: center;
        }

        .add-to-cart-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .add-to-cart-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="product-detail">
        <?php if (isset($error)): ?>
            <h1 class="error"><?= htmlspecialchars($error) ?></h1>
        <?php else: ?>
            <img src="../img/logoG.svg" class="product-image" />

            <h1><?= htmlspecialchars($product['name']) ?></h1>

            <div class="product-description">
                <h2>Descrição</h2>
                <p><?= htmlspecialchars($product['description']) ?></p>
            </div>

            <div class="product-info">
                <h2>Informações do Produto</h2>
                <ul>
                    <li><strong>Preço:</strong> R$ <?= number_format($product['price'], 2, ',', '.') ?></li>
                    <li><strong>Categoria:</strong> <?= htmlspecialchars($product['category']) ?></li>
                    <li><strong>Estoque:</strong> <?= htmlspecialchars($product['stock']) ?> disponível</li>
                </ul>
            </div>

            <div class="product-additional-info">
                <h2>Informações Adicionais</h2>
                <p><?= htmlspecialchars($product['info']) ?></p>
            </div>

            <a href="/vcart<?= $product['id'] ?>" class="add-to-cart-btn">Adicionar ao Carrinho</a>
        <?php endif; ?>
    </div>
</body>

</html>