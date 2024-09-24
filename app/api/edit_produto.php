<?php
// Verifica se o ID foi passado
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $dbFilePath = __DIR__ . '/products.db';

    try {
        // Conexão com o banco de dados
        $pdo = new PDO('sqlite:' . $dbFilePath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Busca as informações do produto com base no ID
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo 'Produto não encontrado!';
            exit;
        }

    } catch (PDOException $e) {
        echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
        exit;
    }

    // Atualiza o produto existente
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['nome'];
        $description = $_POST['descricao'];
        $price = $_POST['preco'];
        $info = $_POST['info'];
        $category = $_POST['categoria'];
        $estoque = $_POST['estoque'];

        try {
            $stmt = $pdo->prepare("UPDATE products SET name = :name, description = :description, price = :price, info = :info, category = :category, estoque = :estoque WHERE id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':info', $info);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':estoque', $estoque);
            $stmt->bindParam(':id', $productId);
            $stmt->execute();

            // Redireciona de volta à página de listagem de produtos
            header("Location: ../pages/adminProdutos.php");
            exit;
        } catch (PDOException $e) {
            echo 'Erro ao atualizar o produto: ' . $e->getMessage();
            exit;
        }
    }

} else {
    echo 'ID do produto não fornecido!';
    exit;
}
?>

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
        <li class="title"><a href="catalogo.php">Loja</a></li>
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
        <h3>Atualizar Produto</h3>

        <form id="productForm" action="" method="POST">
          <div class="input-container">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($product['name']); ?>" required>
          </div>
          <div class="input-container">
            <label for="info">Info:</label>
            <input type="text" id="info" name="info" value="<?php echo htmlspecialchars($product['info']); ?>" required>
          </div>
          <div class="input-container">
            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required>
          </div>
          <div class="input-container">
            <label for="estoque">Estoque:</label>
            <input type="number" id="estoque" name="estoque" value="<?php echo htmlspecialchars($product['estoque']); ?>" required>
          </div>
          <div class="input-container">
            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria" required>
              <option value="petiscos" <?php echo ($product['category'] === 'petiscos') ? 'selected' : ''; ?>>Petiscos</option>
              <option value="brinquedos" <?php echo ($product['category'] === 'brinquedos') ? 'selected' : ''; ?>>Brinquedos</option>
              <option value="acessorios" <?php echo ($product['category'] === 'acessorios') ? 'selected' : ''; ?>>Acessórios</option>
            </select>
          </div>
          <div class="input-container">
            <label for="descricao">Descrição:</label>
            <input id="descricao" name="descricao" required><?php echo htmlspecialchars($product['description']); ?> >
          </div>
          <div class="admin-options">
            <button type="submit" class="admin-btn">Atualizar Produto</button>
            <button type="button" class="admin-btn" onclick="window.location.href='../pages/adminProdutos.php'">Voltar</button>
          </div>
        </form>

        <div id="successPopup" class="popup" style="display: none;">
          Produto atualizado com sucesso!
        </div>

        <div id="errorPopup" class="popup" style="display: none;">
          Erro ao atualizar produto.
        </div>
      </section>
    </section>
  </div>
</body>
</html>
