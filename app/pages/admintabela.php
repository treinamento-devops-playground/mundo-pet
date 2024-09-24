<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel Administrativo - Mundo Pet</title>
  <link rel="stylesheet" href="../css/admintabela.css">
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
      
      <section class="personal-info-section">
        <h3>Cadastro de Produtos</h3>

        <form id="productForm" method="POST">
          <div class="input-container">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
          </div>
          <div class="input-container">
            <label for="info">Info:</label>
            <input type="text" id="info" name="info" required>
          </div>
          <div class="input-container">
            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" step="0.01" required>
          </div>
          <div class="input-container">
            <label for="estoque">Estoque:</label>
            <input type="number" id="estoque" name="estoque" required>
          </div>
          <div class="input-container">
            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria">
              <option value="petiscos">Petiscos</option>
              <option value="brinquedos">Brinquedos</option>
              <option value="acessorios">Acessórios</option>
            </select>
          </div>
          <div class="input-container">
            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao">
          </div>
          <div class="admin-options">
            <button type="submit" name="cadastrar-produto" class="admin-btn">Salvar</button>
            <button class="admin-btn" onclick="window.location.href='adminProdutos.php'">Tabela de Produtos</button>
          </div>
        </form>

        <div id="successPopup" class="popup" style="display: none;">
          Produto salvo com sucesso!
        </div>

        <div id="errorPopup" class="popup" style="display: none;">
          Erro ao cadastrar produto.
        </div>
      </section>
    </section>
  </div>
  <script>
    document.getElementById('productForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);

      fetch('../api/produtos.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          if (data.includes('Produto cadastrado com sucesso')) {
            document.getElementById('productForm').reset();

            const popup = document.getElementById('successPopup');
            popup.style.display = 'block';

            setTimeout(() => {
              popup.style.display = 'none';
            }, 3000);
          } else {
            alert('Erro ao cadastrar produto.');
          }
        })
        .catch(error => console.error('Erro ao salvar o produto:', error));
    });
  </script>
</body>

</html>