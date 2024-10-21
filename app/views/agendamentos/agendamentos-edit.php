<?php $this->layout('agendamentos', ['title' => 'Novo Agendamento']) ?>

<h2>Editar Agendamento</h2>

<div id="agendamentoForm">
    <form id="editAgendamentoForm">
        <div>
            <label for="pet_type">Tipo de Pet:</label>
            <input type="text" id="pet_type" name="pet_type" required>
        </div>
        <div>
            <label for="service_type">Tipo de Serviço:</label>
            <input type="text" id="service_type" name="service_type" required>
        </div>
        <div>
            <label for="date">Data:</label>
            <input type="date" id="date" name="date" required>
        </div>
        <div>
            <label for="time">Hora:</label>
            <input type="time" id="time" name="time" required>
        </div>
        <div>
            <button type="submit">Salvar</button>
        </div>
    </form>

    <div id="message"></div>
</div>

<script>
    const agendamentoId = <?= json_encode($params[0]) ?>;

    async function fetchAgendamento() {
        try {
            const response = await fetch(`/agendamentos/edit/${agendamentoId}`);
            const data = await response.json();

            if (response.ok) {
                document.getElementById('pet_type').value = data.pet_type;
                document.getElementById('service_type').value = data.service_type;
                document.getElementById('date').value = data.date;
                document.getElementById('time').value = data.time;
            } else {
                document.getElementById('message').innerHTML = `<p style="color: red;">${data.error}</p>`;
            }
        } catch (error) {
            console.error('Erro ao buscar agendamento:', error);
        }
    }

    async function updateAgendamento(event) {
        event.preventDefault();

        const pet_type = document.getElementById('pet_type').value;
        const service_type = document.getElementById('service_type').value;
        const date = document.getElementById('date').value;
        const time = document.getElementById('time').value;

        try {
            const response = await fetch(`/agendamentos/update/${agendamentoId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    pet_type,
                    service_type,
                    date,
                    time
                })
            });

            const data = await response.json();

            if (response.ok) {
                document.getElementById('message').innerHTML = `<p style="color: green;">${data.message}</p>`;
            } else {
                document.getElementById('message').innerHTML = `<p style="color: red;">${data.error}</p>`;
            }
        } catch (error) {
            console.error('Erro ao atualizar agendamento:', error);
        }
    }

    document.addEventListener('DOMContentLoaded', fetchAgendamento);

    document.getElementById('editAgendamentoForm').addEventListener('submit', updateAgendamento);
</script>