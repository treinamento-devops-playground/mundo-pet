<!DOCTYPE html>
<html lang="pt-br">
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
        <li class="title"><a href="#">Loja</a></li>
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

        <div class="product-item">
          <div class="product-info">
            <div class="product-image">
              <img src="../img/icons/user.png" alt="Produto">
            </div>
            <div class="product-details">
              <h4>Produto 1</h4>
              <p>Descrição...</p>
            </div>
          </div>
          <div class="product-actions">
            <a href="#" class="edit-btn">editar</a>
            <button class="delete-btn">&#128465;</button> <!-- Ícone de lixeira -->
          </div>
        </div>

        <!-- Botão Adicionar Produto -->
        <div class="add-product">
          <a href="adicionar_produto.php" class="add-product-btn">Adicionar Produto</a>
        </div>
      </section>
    </section>

    

</body>
</html>

