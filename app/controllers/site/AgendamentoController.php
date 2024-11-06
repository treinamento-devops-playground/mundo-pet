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

    public function vis_agen()
    {
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

    public function edit($id)
    {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: /login?message=login_required");
            exit();
        }

        $agendamento = AgendamentoModel::find($id);

        if ($agendamento && $agendamento['user_id'] == $userId) {
            return $this->view('agendamentos/agendamentos-edit', ['agendamento' => $agendamento]);
        } else {
            header("Location: /vis_agen?error=not_found");
            exit();
        }
    }

    public function update($id)
    {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: /login?message=login_required");
            exit();
        }

        $date = $_POST['date'];
        $time = $_POST['time'];

        $agendamentoData = AgendamentoModel::find($id);
        if ($agendamentoData && $agendamentoData['user_id'] == $userId) {
            $currentDate = new \DateTime();
            $agendamentoDate = new \DateTime($date);

            $diff = $currentDate->diff($agendamentoDate);
            if ($diff->days > 3) {
                echo "Você pode alterar o agendamento somente até 3 dias de antecedência.";
                return;
            }

            $data = [
                'pet_type' => $_POST['pet_type'],
                'service_type' => $_POST['service_type'],
                'date' => $date,
                'time' => $time
            ];

            if (AgendamentoModel::update($id, $data)) {
                header("Location: /vis_agen?success=update_success");
            } else {
                echo "Erro ao atualizar agendamento.";
            }
        } else {
            echo "Agendamento não encontrado.";
        }
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
            $mail->Body = "
                <h1>Agendamento Cancelado</h1>
                <p>Seu agendamento foi cancelado com sucesso.</p>
                <p><strong>Motivo do cancelamento:</strong> " . htmlspecialchars($motivo) . "</p>
            ";
            $mail->AltBody = 'Seu agendamento foi cancelado com sucesso. Motivo do cancelamento: ' . $motivo;

            $mail->send();
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");
        }
    }
}
