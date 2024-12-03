<?php $this->layout('admin-base', ['title' => 'Painel Administrativo']); ?>

<?php $this->start('css'); ?>
<link rel="stylesheet" href="../css/admin.css">
<?php $this->stop(); ?>

<?php $this->start('admin-content'); ?>
<div class="user-section">
    <div class="profile-pic">
        <img src="../img/icons/admin.png" alt="Foto do administrador">
    </div>
    <div class="user-info">
        <h2>Administrador</h2>
        <form action="/logout" method="post">
                        <button type="submit" name="logout" class="edit-btn">Logout</button>
                    </form>
    </div>
</div>

<div class="admin-options">
    <button class="admin-btn" onclick="window.location.href='admin/agendamentos'">Agendamentos</button>
    <button class="admin-btn" onclick="window.location.href='admin/products'">Gerenciar Produtos</button>
</div>
<?php $this->stop(); ?>