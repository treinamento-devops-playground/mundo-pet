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
                    header('Location: /agendamentos/create?success=store_success');
                    return $this->view('agendamentos/agendamentos-create');
                } else {
                    header('Location: /agendamentos/create?error=store_error');
                }
            } else {
                header('Location: /agendamentos/create?error=unavailable');
            }
        } catch (\Exception $e) {
            echo "Ocorreu um erro ao processar o agendamento: " . $e->getMessage();
        }
    }

    public function vis_agen(){
        session_start();
        return $this->view('vis_agen');

    }
}
