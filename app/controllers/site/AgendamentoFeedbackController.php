<?php

namespace app\controllers\site;

use app\database\models\SchedulingFeedbackModel;
use app\controllers\BaseController;

class AgendamentoFeedbackController extends BaseController
{
    public function create($schedulingId)
    {
        return $this->view('feedback-create', ['scheduling_id' => $schedulingId]);
    }

    public function store()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login?message=login_required");
            exit();
        }

        $schedulingId = $_POST['scheduling_id'];
        $userId = $_SESSION['user_id'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        if (empty($rating)) {
            echo "Por favor, preencha a avaliação.";
            return;
        }

        try {
            SchedulingFeedbackModel::create($schedulingId, $userId, $rating, $comment);
            header('Location: /agendamentos?success=feedback_submitted');
        } catch (\Exception $e) {
            echo "Erro ao salvar o feedback: " . $e->getMessage();
        }
    }
}
