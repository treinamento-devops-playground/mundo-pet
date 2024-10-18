<?php $this->layout('agendamento', ['title' => 'Editar Agendamento']) ?>

<?php $this->start('form-content') ?>
<h2>Editar Agendamento</h2>

<form action="/agendamentos/<?= $agendamento['id'] ?>/update" method="POST">
    <div>
        <label for="pet_type">Tipo de Pet:</label>
        <input type="text" id="pet_type" name="pet_type" value="<?= htmlspecialchars($agendamento['pet_type']); ?>" required>
    </div>
    <div>
        <label for="service_type">Tipo de Serviço:</label>
        <input type="text" id="service_type" name="service_type" value="<?= htmlspecialchars($agendamento['service_type']); ?>" required>
    </div>
    <div>
        <label for="date">Data:</label>
        <input type="date" id="date" name="date" value="<?= htmlspecialchars($agendamento['date']); ?>" required>
    </div>
    <div>
        <label for="time">Horário:</label>
        <input type="time" id="time" name="time" value="<?= htmlspecialchars($agendamento['time']); ?>" required>
    </div>
    <div>
        <button type="submit">Atualizar Agendamento</button>
    </div>
</form>

<?php $this->stop() ?>