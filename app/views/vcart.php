<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de compras do petshop</title>
    <link rel="stylesheet" href="../css/vcart.css">
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

    <section class="btn-catalogo">
      <a href="catalogo.php" class="catalogo-btn">< Voltar ao catálogo</a>
    </section>
    
  </header>
 
  <section class="title-h3">
      <h3>Lista de Produtos:</h3>
  </section>

  <div id="container">
  
    <section class="content">
      <div>
        <section class="product-list-section">
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
                <a href="../api/edit_produto.php?id=<?php echo $product['id']; ?>" class="edit-btn">Editar</a>
                <button class="delete-btn" onclick="confirmDelete(<?php echo $product['id']; ?>)">&#128465;</button> <!-- Ícone de lixeira -->
              </div>
            </div>
          <?php endforeach; ?>
        </section>
      </div>
    </section>
  </div>

  <!-- Botão de continuar -->
  <div class="btn-continuar">
    <a href="services.php" class="continuar-btn">Continuar ►</a>
  </div>

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