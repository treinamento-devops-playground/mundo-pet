<!DOCTYPE html>
<html lang="pt-br">

<?php
$dbFilePath = __DIR__ . '/../api/products.db';

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

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel Administrativo - Mundo Pet</title>
  <link rel="stylesheet" href="../css/adminProdutos.css">
</head>

<body>
  <header>
    <nav id="nav-bar">
      <div class="logo">
        <img src="../img/logo.png" alt="Logo Mundo Pet">
      </div>
      <ul class="list-nav">
        <li class="title"><a href="#">Serviços</a></li>
        <li class="title"><a href="catalogo.php">Loja</a></li>
        <li class="title"><a href="#">Sobre</a></li>
        <li><a href="#"><img src="../img/icons/user.png"></a></li>
      </ul>
    </nav>
  </header>

  <div id="container">
    <!-- Menu lateral -->
    <aside class="sidebar">
      <h3>Painel Administrativo</h3>
      <ul>
        <li><a href="#">Usuários</a></li>
        <li><a href="#">Relatórios</a></li>
      </ul>
    </aside>

    <section class="content">
      <div class="user-section">
        <div class="profile-pic">
          <img src="../img/icons/user.png" alt="Foto do administrador">
        </div>
        <div class="user-info">
          <h2>Administrador</h2>
          <a href="login.php" class="logout-btn">Logout</a>
        </div>
      </div>
      <div>
        <section class="product-list-section">
          <h3>Lista de Produtos:</h3>

          <?php foreach ($products as $product): ?>
    <div class="product-item">
        <div class="product-info">
            <div class="product-image">
            <img src="../img/logo.png" alt="Produto">
            </div>
            <div class="product-details">
                <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p style="display:inline; margin-right:30px">R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></p>
                <p style="display:inline">Estoque: <?php echo htmlspecialchars($product['estoque']); ?></p>
            </div>
        </div>
        <div class="product-actions">
            <a href="../api/edit_produto.php?id=<?php echo $product['id'];?>" class="edit-btn">Editar</a>
            <button class="delete-btn" onclick="confirmDelete(<?php echo $product['id']; ?>)">&#128465;</button> <!-- Ícone de lixeira -->
        </div>
    </div>
<?php endforeach; ?>

          <!-- Botão Adicionar Produto -->
          <div class="add-product">
            <a href="admintabela.php" class="add-product-btn">Adicionar Produto</a>
            <a href="admin.php" class="add-product-btn">Painel Principal</a>
          </div>
        </section>
    </section>

  <!-- Função de confirmação para deletar produto -->
  <script>
    function confirmDelete(productId) {
        if (confirm('Tem certeza que deseja excluir este produto?')) {
            window.location.href = 'delete.php?id=' + productId;
        }
    }
  </script>
</body>

</html>
