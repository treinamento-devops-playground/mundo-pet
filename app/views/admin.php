<?php $this->layout('admin-base', ['title' => 'Painel Administrativo']); ?>

<?php $this->start('css'); ?>
<link rel="stylesheet" href="../css/admin.css">
<?php $this->stop(); ?>

<?php $this->start('admin-content'); ?>
<div class="user-section">
    <div class="profile-pic">
        <img src="../img/icons/user.png" alt="Foto do administrador">
    </div>
    <div class="user-info">
        <h2>Administrador</h2>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="admin-options">
    <button class="admin-btn" onclick="window.location.href='admin/agendamentos'">Agendamentos</button>
    <button class="admin-btn" onclick="window.location.href='adminProdutos.php'">Gerenciar Produtos</button>
</div>
<?php $this->stop(); ?>