<?php $this->layout('base', [$title]); ?>

<?php $this->start('css'); ?>
<link rel="stylesheet" href="../css/admin.css">
<?php $this->stop(); ?>

<?php $this->start('main-content'); ?>

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
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>

        <div class="admin-options">
            <button class="admin-btn" onclick="window.location.href='adminAgendamentos.php'">Agendamento</button>
            <button class="admin-btn" onclick="window.location.href='adminProdutos.php'">Gerenciar Produtos</button>
        </div>
    </section>
</div>
<?php $this->stop(); ?>