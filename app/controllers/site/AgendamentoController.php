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

        return $this->view('user-scheduling-cancel', ['agendamento_id' => $id]);
    }

    public function vis_agen(){
        session_start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            return $this->view('login', ['error' => 'Faça login.']);
        }

        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM scheduling WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $appointments = $stmt->fetchAll();

        return $this->view('vis_agen', ['agendamentos' => $appointments]);
    }

    private function enviarEmailCancelamento($email, $motivo)
    {
        require_once 'vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '71f21970161a51';
            $mail->Password = '67d7c514be9767';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('no-reply@mundopet.com', 'mundopet');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Agendamento Cancelado';
            $mail->Body    = "
                <h1>Agendamento Cancelado</h1>
                <p>Seu agendamento foi cancelado com sucesso.</p>
                <p><strong>Motivo do cancelamento:</strong> " . htmlspecialchars($motivo) . "</p>
            ";
            $mail->AltBody = 'Seu agendamento foi cancelado com sucesso. Motivo do cancelamento: ' . $motivo;

            $mail->send();
        } catch (\Exception $e) {
            error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");
        }
    }
}
