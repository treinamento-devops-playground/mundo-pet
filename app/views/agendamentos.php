<?php $this->layout('base', ['title' => 'Editar Agendamento']); ?>

<?php $this->start('css'); ?>
<link rel="stylesheet" href="../css/agendamento.css">
<?php $this->stop(); ?>

<?php $this->start('main-content'); ?>
<div class="form-container">
    <form action="store" method="post">
        <div class="form-group">
            <label for="pet-type">Qual tipo de pet:</label>
            <select id="pet-type" name="pet_type">
                <option value="" disabled selected>Selecione uma Opção</option>
                <option value="cachorro">Cachorro</option>
                <option value="gato">Gato</option>
                <option value="outro">Outro</option>
            </select>
        </div>

        <div class="form-group">
            <label for="service-type">Tipo de Atendimento:</label>
            <select id="service-type" name="service_type">
                <option value="" disabled selected>Selecione uma Opção</option>
                <option value="consulta">Consulta</option>
                <option value="banho_tosa">Banho e Tosa</option>
                <option value="vacina">Vacinação</option>
            </select>
        </div>

        <div class="form-group">
            <label for="date">Data:</label>
            <input type="date" id="date" name="date">
        </div>

        <div class="form-group">
            <label for="time">Hora:</label>
            <input type="time" id="time" name="time">
        </div>

        <button type="submit" class="submit-btn">Agendar</button>
    </form>
</div>
<?php $this->stop(); ?>