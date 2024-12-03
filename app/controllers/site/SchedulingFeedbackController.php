<?php

namespace app\controllers\site;

use app\controllers\BaseController;
use app\services\contracts\ISchedulingFeedbackService;

class SchedulingFeedbackController extends BaseController
{
    private ISchedulingFeedbackService $feedbackService;

    public function __construct(ISchedulingFeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function create($schedulingId)
    {
        return $this->view('scheduling-feedback-create', ['scheduling_id' => $schedulingId]);
    }

    public function store()
    {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['error' => 'JSON inválido']);
            exit();
        }

        $requiredFields = ['scheduling_id', 'user_id', 'rating'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                http_response_code(400);
                echo json_encode(['error' => "O campo '{$field}' é obrigatório"]);
                exit();
            }
        }

        try {
            $this->feedbackService->createFeedback($data);
            http_response_code(201);
            echo json_encode(['message' => 'Feedback criado com sucesso']);
            exit();
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao salvar o feedback: ' . $e->getMessage()]);
            exit();
        }
    }

    private function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
