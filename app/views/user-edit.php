<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../css/user-edit.css"> 
</head>
<body>
    <div class="container">
        <header class="header">
            <img src="../img/logo.png" alt="Logo" class="logo">
            <nav class="nav">
                <a href="#">Serviços</a>
                <a href="#">Loja</a>
                <a href="#">Sobre</a>
                <div class="profile-icon">
                    <img src="../img/profile.png" alt="Perfil">
                </div>
            </nav>
        </header>

        <div class="sidebar">
            <button class="sidebar-btn">Meu Perfil</button>
            <button class="sidebar-btn">Agendamentos</button>
        </div>

        <main class="main-content">
            <section class="profile-section">
                <div class="profile-header">
                    <img src="../img/user-avatar.png" alt="Avatar" class="avatar">
                    <input type="text" value="<?= htmlspecialchars($user['username']) ?>" class="username-input">
                </div>
                <div class="edit-btn">
                    <button>Salvar</button>
                </div>
            </section>

            <section class="info-section">
                <h3>Informações Pessoais</h3>
                <div class="info-group">
                    <label>Nome</label>
                    <input type="text" placeholder="Nome" value="<?= htmlspecialchars($user['username']) ?>">
                </div>
                <div class="info-group">
                    <label>Email</label>
                    <input type="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>">
                </div>
                <div class="info-group">
                    <label>Celular</label>
                    <input type="tel" placeholder="Celular" value="<?= htmlspecialchars($user['phone']) ?>">
                </div>
                <div class="info-group">
                    <label>Senha</label>
                    <input type="password" placeholder="Senha">
                </div>
                <div class="edit-btn">
                    <button>Salvar</button>
                </div>
            </section>

            <section class="address-section">
                <h3>Endereço</h3>
                <div class="address-group">
                    <label>Cidade</label>
                    <input type="text" placeholder="Cidade" value="<?= htmlspecialchars($user['city']) ?>">
                    <label>UF</label>
                    <input type="text" placeholder="UF" value="<?= htmlspecialchars($user['state']) ?>">
                </div>
                <div class="address-group">
                    <label>Rua</label>
                    <input type="text" placeholder="Rua" value="<?= htmlspecialchars($user['street']) ?>">
                    <label>Número</label>
                    <input type="text" placeholder="Número" value="<?= htmlspecialchars($user['number']) ?>">
                </div>
                <div class="address-group">
                    <label>CEP</label>
                    <input type="text" placeholder="CEP" value="<?= htmlspecialchars($user['postal_code']) ?>">
                </div>
                <div class="address-group">
                    <label>Complemento</label>
                    <input type="text" placeholder="Complemento" value="<?= htmlspecialchars($user['complement']) ?>">
                </div>
                <div class="edit-btn">
                    <button>Salvar</button>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
