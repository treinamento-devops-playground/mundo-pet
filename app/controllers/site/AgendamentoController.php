<?php

namespace app\controllers\site;

use app\controllers\BaseController;
use app\services\email\CancellationEmail;
use app\services\IAgendamentoService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AgendamentoController extends BaseController
{
    private $agendamentoService;

    public function __construct(IAgendamentoService $agendamentoService)
    {
        $this->agendamentoService = $agendamentoService;
    }

    public function create()
    {
        return $this->view('agendamentos/agendamentos-create');
    }

    public function store()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login?message=login_required");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $data = [
            'user_id' => $userId,
            'pet_type' => $_POST['pet_type'] ?? null,
            'service_type' => $_POST['service_type'] ?? null,
            'date' => $_POST['date'] ?? null,
            'time' => $_POST['time'] ?? null
        ];

        try {
            $this->agendamentoService->createAgendamento($data);
            header('Location: /agendamentos/create?success=store_success');
            exit();
        } catch (\Exception $e) {
            echo "Ocorreu um erro ao processar o agendamento: " . $e->getMessage();
        }
    }

    public function cancelForm($id)
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login?message=login_required");
            exit();
        }

        $agendamento = $this->agendamentoService->getAgendamentoById($id);

        if (!$agendamento || $agendamento->getUserId() != $_SESSION['user_id']) {
            header("Location: /agendamentos?error=not_found");
            exit();
        }

        return $this->view('user-scheduling-cancel', ['agendamento' => $agendamento]);
    }

    public function confirmCancel($id)
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login?message=login_required");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $userEmail = $_SESSION['email'];
        $motivo = $_POST['motivo'] ?? '';

        if (empty($motivo)) {
            header("Location: /agendamentos/cancelar/$id?error=empty_reason");
            exit();
        }

        $agendamento = $this->agendamentoService->getAgendamentoById($id);

        if (!$agendamento || $agendamento->getUserId() != $userId) {
            header("Location: /agendamentos?error=not_found");
            exit();
        }

        try {
            $agendamento->setStatus('cancelado');
            $agendamento->setMotivoCancelamento($motivo);
            $this->agendamentoService->updateAgendamento($agendamento);

            $email = new CancellationEmail();
            $email->sendEmail($userEmail, ['motivo' => $motivo]);

            header("Location: /agendamentos/cancelar/$id?success=canceled");
            exit();
        } catch (\Exception $e) {
            header("Location: /agendamentos/cancelar/$id?error=exception");
            exit();
        }
    }

    public function vis_agen()
    {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            return $this->view('user/login', ['error' => 'Faça login']);
        }

        $user = $this->agendamentoService->getUserById($userId);
        if (!$user) {
            return $this->view('/login', ['error' => 'Usuário não encontrado.']);
        }

        $appointments = $this->agendamentoService->getAgendamentosByUserId($userId);

        return $this->view('vis_agen', [
            'username' => $user['username'],
            'agendamentos' => $appointments
        ]);
    }
}
