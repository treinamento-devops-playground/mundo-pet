<?php $this->layout('admin-base', ['title' => 'Editar Agendamento']) ?>

<?php $this->start('admin-content'); ?>
<div id="agendamentoForm" style="background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 100%; max-width: 500px; margin: auto;">
    <h2 style="text-align: center; margin-bottom: 20px; color: #333;">Editar Agendamento</h2>
    <form id="editAgendamentoForm" method="post" action="/admin/agendamentos/update/<?= htmlspecialchars($agendamento->getId()); ?>">
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="pet_type" style="display: block; margin-bottom: 5px; font-weight: 500; color: #333;">Tipo de Pet:</label>
            <input type="text" id="pet_type" name="pet_type" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="service_type" style="display: block; margin-bottom: 5px; font-weight: 500; color: #333;">Tipo de Serviço:</label>
            <input type="text" id="service_type" name="service_type" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="date" style="display: block; margin-bottom: 5px; font-weight: 500; color: #333;">Data:</label>
            <input type="date" id="date" name="date" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="time" style="display: block; margin-bottom: 5px; font-weight: 500; color: #333;">Hora:</label>
            <input type="time" id="time" name="time" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="ativo" <?= $agendamento->getStatus() == 'ativo' ? 'selected' : '' ?>>Ativo</option>
                <option value="cancelado" <?= $agendamento->getStatus() == 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                <option value="concluído" <?= $agendamento->getStatus() == 'concluído' ? 'selected' : '' ?>>Concluído</option>
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <button type="submit" style="width: 100%; padding: 10px; background-color: #6B6EAF; color: #fff; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; transition: background-color 0.3s;">Salvar</button>
        </div>
    </form>
    <div id="message" style="margin-top: 20px; text-align: center;"></div>
</div>
<?php $this->stop(); ?>

<?php $this->start('js'); ?>
<script>
    const agendamentoId = <?= htmlspecialchars($agendamento->getId()); ?>;
    const agendamento = <?= json_encode($agendamento) ?>;

    console.log(agendamentoId);
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('pet_type').value = "<?= htmlspecialchars($agendamento->getPetType()); ?>";
        document.getElementById('service_type').value = "<?= htmlspecialchars($agendamento->getServiceType()); ?>";
        document.getElementById('date').value = "<?= htmlspecialchars($agendamento->getDate()); ?>";
        document.getElementById('time').value = "<?= htmlspecialchars($agendamento->getTime()); ?>";
        document.getElementById('status').value = "<?= htmlspecialchars($agendamento->getStatus()); ?>";
    });

    async function updateAgendamento(event) {
        event.preventDefault();

        const data = {
            pet_type: document.getElementById('pet_type').value,
            service_type: document.getElementById('service_type').value,
            date: document.getElementById('date').value,
            time: document.getElementById('time').value,
            status: document.getElementById('status').value,
        };

        try {
            const response = await fetch(`/admin/agendamentos/update/${agendamentoId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || 'Erro ao atualizar o agendamento');
            }

            showMessage('success', 'Agendamento editado com sucesso');
        } catch (error) {
            console.error('Erro ao atualizar agendamento:', error.message);
            showMessage('error', 'Erro ao atualizar o agendamento.');
        }
    }

    function showMessage(type, message) {
        const messageDiv = document.getElementById('message');
        messageDiv.innerHTML = `<p class="${type}" style="padding: 10px; border-radius: 5px; ${
            type === 'success' ? 'background-color: #d4edda; color: #155724;' : 'background-color: #f8d7da; color: #721c24;'
        }">${message}</p>`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetchAgendamento(agendamentoId);
    });

    document.getElementById('editAgendamentoForm').addEventListener('submit', updateAgendamento);
</script>
<?php $this->stop(); ?>