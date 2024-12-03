<?php $this->layout('userbase', ['title' => 'Cancelar Agendamento']); ?>

<?php $this->start('css'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap');

    .cancel-agendamento-container {
        width: 100%;
        max-width: 70%;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: center;
        flex-direction: column;
        margin: 50px auto;
        font-family: 'Roboto', sans-serif;
    }

    .cancel-agendamento-container h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .cancel-agendamento-container p {
        font-size: 16px;
        margin-bottom: 20px;
        color: #666;
    }

    .cancel-agendamento-container ul {
        list-style: none;
        margin-bottom: 20px;
        padding: 0;
    }

    .cancel-agendamento-container ul li {
        font-size: 16px;
        margin-bottom: 10px;
        color: #333;
    }

    .cancel-agendamento-container ul li strong {
        font-weight: 700;
    }

    .cancel-agendamento-container form {
        display: flex;
        flex-direction: column;
    }

    .cancel-agendamento-container form label {
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
    }

    .cancel-agendamento-container form textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        resize: vertical;
        margin-bottom: 15px;
    }

    .cancel-agendamento-container form button {
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

    .cancel-agendamento-container form button:hover {
        background-color: #c9302c;
    }
    
</style>
<?php $this->stop(); ?>

<?php $this->start('main-content'); ?>
<div class="cancel-agendamento-container">
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
