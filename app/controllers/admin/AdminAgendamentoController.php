<?php

namespace app\controllers\admin;

use app\controllers\BaseController;
use app\services\contracts\IAdminAgendamentoService;

class AdminAgendamentoController extends BaseController
{
    private IAdminAgendamentoService $agendamentoService;

    public function __construct(IAdminAgendamentoService $agendamentoService)
    {
        $this->agendamentoService = $agendamentoService;
    }

    public function show()
    {
        $agendamentos = $this->agendamentoService->getAgendamentos();
        return $this->view('admin-agendamentos', ['agendamentos' => $agendamentos]);
    }

    public function edit($params)
    {
        $id = $params[0];
        $agendamento = $this->agendamentoService->getAgendamentoById($id);

        if (!$agendamento) {
            return $this->jsonResponse(['error' => 'Agendamento não encontrado'], 404);
        }

        return $this->view('admin-agendamentos-edit', ['agendamento' => $agendamento]);
    }

    public function update($params)
    {
        try {
            $id = $params[0];
            $data = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->jsonResponse(['error' => 'JSON inválido'], 400);
            }

            $agendamentoAtualizado = $this->agendamentoService->updateAgendamento($id, $data);

            return $this->jsonResponse([
                'message' => 'Agendamento atualizado com sucesso',
                'agendamento' => [
                    'id' => $agendamentoAtualizado->getId(),
                    'user_id' => $agendamentoAtualizado->getUserId(),
                    'pet_type' => $agendamentoAtualizado->getPetType(),
                    'service_type' => $agendamentoAtualizado->getServiceType(),
                    'date' => $agendamentoAtualizado->getDate(),
                    'time' => $agendamentoAtualizado->getTime(),
                    'status' => $agendamentoAtualizado->getStatus(),
                ]
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse(['error' => $e->getMessage()], 400);
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
