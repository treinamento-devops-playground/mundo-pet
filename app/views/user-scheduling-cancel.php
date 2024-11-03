<?php $this->layout('base', ['title' => 'Cancelar Agendamento']); ?>

<?php $this->start('css'); ?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 400px;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 15px;
        color: #333;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #555;
    }

    textarea {
        width: 100%;
        height: 100px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        resize: none;
    }

    button {
        margin-top: 15px;
        padding: 10px;
        width: 100%;
        background-color: #d9534f;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #c9302c;
    }
</style>
<?php $this->stop(); ?>

<?php $this->start('main-content'); ?>
<div class="container">
    <h1>Cancelar Agendamento</h1>
    <form action="/agendamentos/cancelar/<?= htmlspecialchars($agendamento_id) ?>" method="post">
        <label for="motivo">Motivo do Cancelamento:</label>
        <textarea name="motivo" id="motivo" required></textarea>
        <button type="submit">Confirmar Cancelamento</button>
    </form>
</div>
<?php $this->stop(); ?>