<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?message=login_required");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento - Mundo Pet</title>
    <link rel="stylesheet" href="../css/agendamento.css">
</head>

<body>
    <div class="container">
        <header class="header">
            <img src="../img/logo.png" alt="Mundo Pet Logo" class="logo">
            <nav>
                <ul class="nav-links">
                    <li><a href="#">Serviços</a></li>
                    <li><a href="#">Loja</a></li>
                    <li><a href="#">Sobre</a></li>
                    <li><a href="#"><img src="../img/icons/user.png"></a></li>
                </ul>
            </nav>
        </header>

        <main>
            <div class="form-container">
                <h2>Preencha o Formulário abaixo:</h2>
                <form action="submit.php" method="post">
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
        </main>
    </div>

</body>

</html>