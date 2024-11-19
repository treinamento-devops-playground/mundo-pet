<?php $this->layout('base', ['title' => 'Cancelar Agendamento']); ?>
<?php $this->start('css'); ?>
<link rel="stylesheet" href="../css/user-scheduling-cancel.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap');

    .container {
        width: 100%;
        max-width: 70%;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: center;
        top: 50%;
        left: 50%;
        flex-direction: column;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    p {
        font-size: 16px;
        margin-bottom: 20px;
        color: #666;
    }

    ul {
        list-style: none;
        margin-bottom: 20px;
    }

    ul li {
        font-size: 16px;
        margin-bottom: 10px;
        color: #333;
    }

    ul li strong {
        font-weight: 700;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    form label {
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
    }

    form textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        resize: vertical;
        margin-bottom: 15px;
    }

    form button {
        width: 100%;
        padding: 10px;
        background-color: #d9534f;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    form button:hover {
        background-color: #c9302c;
    }
</style>
<?php $this->stop(); ?>

<?php $this->start('main-content'); ?>
<div class="container">
    <h1>Cancelar Agendamento</h1>
    <p>Tem certeza de que deseja cancelar o agendamento abaixo?</p>

    <ul>
        <li><strong>Data:</strong> <?= htmlspecialchars(date('d/m/Y', strtotime($agendamento->getDate()))) ?></li>
        <li><strong>Hora:</strong> <?= htmlspecialchars(date('H:i', strtotime($agendamento->getTime()))) ?></li>
        <li><strong>Tipo de Pet:</strong> <?= htmlspecialchars($agendamento->getPetType()) ?></li>
        <li><strong>Serviço:</strong> <?= htmlspecialchars($agendamento->getServiceType()) ?></li>
        <?php if ($agendamento->getStatus()): ?>
            <li><strong>Status:</strong> <?= htmlspecialchars($agendamento->getStatus()) ?></li>
        <?php endif; ?>
        <?php if ($agendamento->getMotivoCancelamento()): ?>
            <li><strong>Motivo do Cancelamento:</strong> <?= htmlspecialchars($agendamento->getMotivoCancelamento()) ?></li>
        <?php endif; ?>
    </ul>

    <form action="/agendamentos/cancelar/confirmar/<?= htmlspecialchars($agendamento->getId()); ?>" method="post">
        <label for="motivo">Motivo do Cancelamento:</label>
        <textarea name="motivo" id="motivo" required></textarea>
        <button type="submit">Confirmar Cancelamento</button>
    </form>
</div>
<?php $this->stop(); ?>