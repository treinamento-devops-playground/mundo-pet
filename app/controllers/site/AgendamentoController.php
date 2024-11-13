<?php

namespace app\controllers\site;

use app\database\models\AgendamentoModel;
use app\controllers\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use app\database\Connection;



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


    public function cancelForm($id)
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login?message=login_required");
            exit();
        }

        $agendamento = AgendamentoModel::find($id);

        if (!$agendamento || $agendamento['user_id'] != $_SESSION['user_id']) {
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

        $agendamento = AgendamentoModel::find($id);

        if (!$agendamento || $agendamento['user_id'] != $userId) {
            header("Location: /agendamentos?error=not_found");
            exit();
        }

        try {
            if (AgendamentoModel::cancel($id, $userId, $motivo)) {
                $this->enviarEmailCancelamento($userEmail, $motivo);
                header("Location: /agendamentos/cancelar/$id?success=canceled");
                exit();
            } else {
                header("Location: /agendamentos/cancelar/$id?error=cancel_failed");
                exit();
            }
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

        $user = AgendamentoModel::getUserById($userId);
        if (!$user) {
            return $this->view('user/login', ['error' => 'Usuário não encontrado.']);
        }

        $appointments = AgendamentoModel::getAgendamentosByUserId($userId);

        return $this->view('vis_agen', [
            'username' => $user['username'],
            'agendamentos' => $appointments
        ]);
    }

    private function enviarEmailCancelamento($email, $motivo)
    {
        require_once __DIR__ . '/../../../vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '71f21970161a51';
            $mail->Password = '67d7c514be9767';

            $mail->setFrom('no-reply@demomailtrap.com', 'MundoPet');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Confirmação de Cancelamento de Agendamento';
            $mail->Body    = "
                <h1>Agendamento Cancelado</h1>
                <p>Seu agendamento foi cancelado com sucesso.</p>
                <p><strong>Motivo do cancelamento:</strong> " . htmlspecialchars($motivo) . "</p>
            ";
            $mail->AltBody = 'Seu agendamento foi cancelado com sucesso. Motivo do cancelamento: ' . $motivo;

            $mail->SMTPDebug = 2;
            $mail->send();
            echo 'Email enviado com sucesso!';
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");
        }
    }
}
