<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?message=login_required");
    exit();
}

// Conectar ao banco de dados SQLite no caminho especificado
try {
    // Definir o caminho do banco de dados existente
    $db_path = __DIR__ . '/../api/products.db';

    // Criar tabela 'agendamentos' se não existir
    $db = new PDO('sqlite:' . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec('CREATE TABLE IF NOT EXISTS agendamentos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        pet_type TEXT,
        service_type TEXT,
        date TEXT,
        time TEXT
    )');

    // Função para verificar se o horário está disponível para o mesmo usuário e serviço
    function verificarDisponibilidade($db, $user_id, $data, $hora, $service_type) {
        // Adicionar depuração
        echo "Verificando: user_id: $user_id, date: $data, time: $hora, service_type: $service_type<br>";
    
        $stmt = $db->prepare("SELECT * FROM agendamentos 
                              WHERE user_id = :user_id 
                              AND date = :date 
                              AND time = :time 
                              AND service_type = :service_type");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':date', $data);
        $stmt->bindParam(':time', $hora);
        $stmt->bindParam(':service_type', $service_type);
        $stmt->execute();
    
        // Depurar o número de linhas retornadas
        echo "Número de agendamentos encontrados: " . $stmt->rowCount() . "<br>";
    
        return $stmt->rowCount() === 0; 
    }
    

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $petType = $_POST['pet_type'];
        $serviceType = $_POST['service_type'];
        $data = $_POST['date'];
        $hora = $_POST['time'];

        // Validar os dados
        if (empty($petType) || empty($serviceType) || empty($data) || empty($hora)) {
            echo "Por favor, preencha todos os campos.";
            exit();
        }

        // Para depuração
        echo "Dados recebidos: Tipo de pet: $petType, Tipo de serviço: $serviceType, Data: $data, Hora: $hora<br>";
        echo verificarDisponibilidade($db, $_SESSION['user_id'], $data, $hora, $serviceType);

        // Verificar se o horário está dentro do intervalo de 08:00-12:00 e 14:00-18:00
        $horaSemMinutos = date('H:i', strtotime($hora));
        if (($hora >= "08:00" && $hora < "12:00") || ($hora >= "14:00" && $hora < "18:00")) {
            // Verificar se o mesmo usuário já tem um agendamento para o mesmo serviço nesse horário e data
            if (verificarDisponibilidade($db, $_SESSION['user_id'], $data, $hora, $serviceType)) {
                // Inserir o agendamento no banco de dados
                $stmt = $db->prepare("INSERT INTO agendamentos (user_id, pet_type, service_type, date, time) 
                                      VALUES (:user_id, :pet_type, :service_type, :date, :time)");
                $stmt->bindParam(':user_id', $_SESSION['user_id']);
                $stmt->bindParam(':pet_type', $petType);
                $stmt->bindParam(':service_type', $serviceType);
                $stmt->bindParam(':date', $data);
                $stmt->bindParam(':time', $hora);

                if ($stmt->execute()) {
                    echo "Agendamento realizado com sucesso!";
                } else {
                    echo "Erro ao agendar. Tente novamente.";
                }
            } else {
                echo "Você já tem um agendamento para esse serviço na mesma data e horário.";
            }
        } else {
            echo "Horário inválido. Escolha um horário entre 08:00-12:00 ou 14:00-18:00.";
        }
    }
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
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
                <form action="" method="post">
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
