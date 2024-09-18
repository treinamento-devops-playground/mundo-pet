<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil do Usuário - Mundo Pet</title>
  <link rel="stylesheet" href="../css/usuario.css">

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
      <h3>Meu Perfil</h3>
    </aside>

    <!-- Área de edição do usuário -->
    <section class="content">
      <!-- Seção de nome do usuário -->
      <div class="user-section">
        <div class="profile-pic">
          <img src="../img/icons/user.png" alt="Foto do usuário">
        </div>
        <div class="user-info">
          <h2>User Name</h2>
        </div>
        <a href="#" class="edit-btn">Editar</a>
      </div>

      <!-- Seção de informações pessoais -->
      <div class="personal-info-section">
        <h3>Informações Pessoais</h3>
        <div class="input-container">
      <img src="../img/icons/user-fill.png">
      <input type="text" placeholder="Nome">
        </div>
        <div class="input-container">
      <img src="../img/icons/email.png">
      <input type="email" placeholder="Email">
        </div>
        <div class="input-container">
      <img src="../img/icons/phone-solid.png">
      <input type="number_format" placeholder="Celular">
        </div>
        <div class="input-container">
      <img src="../img/icons/padlock.png">
      <input type="password" placeholder="Senha">
        </div>
        <a href="#" class="edit-btn">Editar</a>
      </div>

      <!-- Seção de endereço -->
      <div class="address-section">
        <h3>Endereço</h3>
        <div class="input-container">
          <label for="cidade">Cidade</label>
          <input type="text" id="cidade" value="">
        </div>
        <div class="input-container">
          <label for="uf">UF</label>
          <input type="text" id="uf" value="">
        </div>
        <div class="input-container">
          <label for="rua">Rua</label>
          <input type="text" id="rua" value="">
        </div>
        <div class="input-container">
          <label for="cep">CEP</label>
          <input type="text" id="cep" value="">
        </div>
        <div class="input-container">
          <label for="numero">Nº</label>
          <input type="text" id="numero" value="">
        </div>
        <div class="input-container">
          <label for="complemento">Complemento</label>
          <input type="text" id="complemento" value="">
        </div>
        <a href="#" class="edit-btn">Editar</a>
      </div>
    </section>
  </div>
</body>
</html>
