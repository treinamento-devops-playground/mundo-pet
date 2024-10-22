<?php $this->layout('admin-base', ['title' => 'Editar Agendamento']) ?>

<?php $this->start('css'); ?>
<link rel="stylesheet" href="../css/admin-agendamentos-edit">
<?php $this->stop(); ?>

<?php $this->start('admin-content'); ?>
<div id="agendamentoForm">
    <form action="admin/agendamentos/update/<?= $agendamento['id'] ?>" id="editAgendamentoForm">
        <div class="form-group">
            <label for="pet_type">Tipo de Pet:</label>
            <input type="text" id="pet_type" name="pet_type">
        </div>
        <div class="form-group">
            <label for="service_type">Tipo de Serviço:</label>
            <input type="text" id="service_type" name="service_type">
        </div>
        <div class="form-group">
            <label for="date">Data:</label>
            <input type="date" id="date" name="date">
        </div>
        <div class="form-group">
            <label for="time">Hora:</label>
            <input type="time" id="time" name="time">
        </div>
        <div class="form-group">
            <button type="submit">Salvar</button>
        </div>
    </form>

</div>
<?php $this->stop(); ?>

<?php $this->start('js'); ?>
<script>
    const agendamentoId = <?= json_encode($params[0]) ?>;

    async function fetchAgendamento(agendamentoId) {
        try {
            const response = await fetch(`/admin/agendamentos/edit/${agendamentoId}`);
            if (!response.ok) {
                const errorData = await response.json();
                console.error('Erro detalhado:', errorData);
                throw new Error('Erro ao buscar agendamento');
            }
            const agendamento = await response.json();
            console.log('Agendamento encontrado:', agendamento);

            document.getElementById('pet_type').value = agendamento.pet_type;
            document.getElementById('service_type').value = agendamento.service_type;
            document.getElementById('date').value = agendamento.date;
            document.getElementById('time').value = agendamento.time;
        } catch (error) {
            console.error('Erro ao buscar agendamento:', error);
            showMessage('error', 'Erro ao buscar o agendamento.');
        }
    }

    function showMessage(type, message) {
        const messageDiv = document.getElementById('message');
        messageDiv.innerHTML = `<p class="${type}">${message}</p>`;
    }

    document.addEventListener('DOMContentLoaded', () => fetchAgendamento(agendamentoId));
    document.getElementById('editAgendamentoForm').addEventListener('submit', updateAgendamento);
</script>
<?php $this->stop(); ?>