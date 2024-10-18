<?php

namespace app\controllers\site;

use app\database\models\Agendamento;
use app\controllers\ContainerController;

class AgendamentoController extends ContainerController
{
    public function create()
    {
        try {
            // Renderiza a view de criação de agendamentos
            return $this->view('agendamentos/agendamentos-create');
        } catch (\Exception $e) {
            echo $e->getMessage();  // Captura e exibe erros se a view não existir
        }
    }

    public function store()
    {
        session_start();

        // Verifica se o usuário está autenticado
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login?message=login_required");
            exit();
        }

        // Captura os dados enviados pelo formulário
        $userId = $_SESSION['user_id'];
        $petType = $_POST['pet_type'];
        $serviceType = $_POST['service_type'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        // Valida os dados obrigatórios
        if (empty($petType) || empty($serviceType) || empty($date) || empty($time)) {
            echo "Por favor, preencha todos os campos.";
            return;
        }

        try {
            // Verifica a disponibilidade e cria o agendamento se possível
            if (Agendamento::isAvailable($userId, $date, $time, $serviceType)) {
                if (Agendamento::create($userId, $petType, $serviceType, $date, $time)) {
                    echo "Agendamento realizado com sucesso!";
                } else {
                    echo "Erro ao agendar. Tente novamente.";
                }
            } else {
                echo "Você já tem um agendamento para esse serviço na mesma data e horário.";
            }
        } catch (\Exception $e) {
            echo "Ocorreu um erro ao processar o agendamento: " . $e->getMessage();
        }
    }
}
