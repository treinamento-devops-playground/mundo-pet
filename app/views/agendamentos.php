<?php $this->layout('userbase', ['title' => 'Editar Agendamento']); ?>

<?php $this->start('css'); ?>
<link rel="stylesheet" href="../css/agendamento.css">
<?php $this->stop(); ?>

<?php $this->start('main-content'); ?>
<div class="container">
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
                <option value="adestramento">Adestramento</option>
                <option value="dog_walker">Dog Walker</option>
            </select>
        </div>

        <div class="form-group">
            <label for="date">Data:</label>
            <input type="date" id="date" name="date" onchange="validarData(this)" min="<?php echo date('Y-m-d'); ?>"> 
        </div>

        <div class="form-group">
            <label for="time">Hora:</label>
            <select id="time" name="time" class="styled-select">
                <option value="" disabled selected>Selecione um horário</option>
                <?php
                    $inicio = strtotime('08:00');
                    $fim = strtotime('18:00');

                    for ($horario = $inicio; $horario <= $fim; $horario += 30 * 60) {
                        $horaFormatada = date('H:i', $horario);
                        echo "<option value=\"$horaFormatada\">$horaFormatada</option>";
                    }
                ?>
            </select>
        </div>

        <button type="submit" class="submit-btn">Agendar</button>

        <a href="/user/agendamentos" class="view-btn">Ver Meus Agendamentos</a>
    </form>
</div>

<div id="popup-message" class="popup-message">
    <div class="popup-content">
        <span id="popup-close" class="popup-close">&times;</span>
        <p id="popup-text"></p>
    </div>
</div>

<?php $this->stop(); ?>

<?php $this->start('js'); ?>
<script>
    function validarData(input) {
        const dataSelecionada = new Date(input.value);
        const diaDaSemana = dataSelecionada.getUTCDay(); 

        if (diaDaSemana === 0 || diaDaSemana === 6) {
            alert('Selecione uma data entre segunda-feira e sexta-feira.');
            input.value = ''; 
        }
    }

    function showPopup(message, type) {
        const popup = document.getElementById("popup-message");
        const popupText = document.getElementById("popup-text");
        const popupClose = document.getElementById("popup-close");

        popupText.textContent = message;
        popup.classList.add(type); 
        popup.style.display = "flex";  

        popupClose.onclick = function() {
            popup.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == popup) {
                popup.style.display = "none";
            }
        }
    }

    window.onload = function() {
        <?php if (isset($_GET['success'])): ?>
            showPopup("Agendamento efetuado com sucesso!", "success");
        <?php elseif (isset($_GET['error'])): ?>
            showPopup("Ocorreu um erro ao processar o agendamento.", "error");
        <?php endif; ?>
    }
</script>
<?php $this->stop(); ?>
