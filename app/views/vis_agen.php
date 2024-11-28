<?php
session_start();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();

    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Agendamentos</title>
    <link rel="icon" href="/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/vis_agen.css">
</head>

<body>
    <div id="usernav-bar">
        <?php $this->insert('partials/usernav-bar'); ?>
    </div>

    <div class="container">
        <aside class="sidebar">
            <a href="/user/edit"><button>Meu Perfil</button></a>
            <button>Agendamentos</button>
        </aside>

        <main class="content">
            <div class="user-card">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <img src="../img/icons/user.png" alt="Foto do usuário" class="user-avatar">
                    <span class="user-name"><?= htmlspecialchars($_SESSION['email']) ?></span>

                    <form action="/logout" method="post">
                        <button type="submit" name="logout" class="edit-btn">Logout</button>
                    </form>
                <?php else: ?>
                    <p>Você não está logado.</p>
                <?php endif; ?>
            </div>

            <?php if (!empty($agendamentos)): ?>
                <?php foreach ($agendamentos as $item): ?>
                    <div class="appointment">
                        <div class="titulo">
                            <p> <?= htmlspecialchars($item->getServiceType()); ?></p>
                            <p> <?= htmlspecialchars($item->getDate()); ?></p>
                            <p>Horário: <?= htmlspecialchars($item->getTime()); ?></p>
                        </div>
                        <div class="button-group">
                            <button class="delete-btn"><a href="/agendamentos/cancelar/<?= htmlspecialchars($item->getId()); ?>" class="cancel-link">✖</a></button>
                        </div>
                        <?php if ($item->getStatus() == 'concluído'): ?>
                            <a href="/scheduling-feedback/create/<?= htmlspecialchars($item->getId()); ?>"><button>Dar feedback</button></a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Você não tem agendamentos no momento.</p>
            <?php endif; ?>
        </main>
    </div>
</body>

</html>