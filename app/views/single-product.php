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
    <link rel="stylesheet" href="../css/single-product.css">
    
</head>

<body>
<header>
        <div class="logo">
            <img src="../img/logo.png" alt="Logo">
        </div>
        <ul class="list-nav">
            <li class="title"><a href="/services">Serviços</a></li>
            <li class="title"><a href="/catalog">Loja</a></li>
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