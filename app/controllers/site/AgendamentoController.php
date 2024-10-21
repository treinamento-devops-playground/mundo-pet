<?php

namespace app\controllers\site;

use app\database\models\AgendamentoModel;
use app\controllers\BaseController;

class AgendamentoController extends BaseController
{
    public function create()
    {
        try {
            return $this->view('agendamentos/agendamentos-create');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function store()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login?message=login_required");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $petType = $_POST['pet_type'];
        $serviceType = $_POST['service_type'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        if (empty($petType) || empty($serviceType) || empty($date) || empty($time)) {
            echo "Por favor, preencha todos os campos.";
            return;
        }

        try {
            if (AgendamentoModel::isAvailable($userId, $date, $time, $serviceType)) {
                if (AgendamentoModel::create($userId, $petType, $serviceType, $date, $time)) {
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
