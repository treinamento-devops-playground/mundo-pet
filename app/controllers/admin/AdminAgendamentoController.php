<?php

namespace app\controllers\admin;

use app\database\models\AgendamentoModel;
use core\Request;
use app\controllers\BaseController;

class AdminAgendamentoController extends BaseController
{
    public function show()
    {
        $agendamentos = AgendamentoModel::all();
        return $this->view('admin-agendamentos', ['agendamentos' => $agendamentos]);
    }

    public function edit($params)
    {
        $id = $params[0];
        $agendamento = AgendamentoModel::find($id);

        if (!$agendamento) {
            return $this->jsonResponse(['error' => 'Agendamento não encontrado'], 404);
        }

        return $this->view('admin-agendamentos-edit', ['agendamento' => $agendamento]);
    }

    public function update($params)
    {
        $id = $params[0];

        $data = Request::only(['pet_type', 'service_type', 'date', 'time']);

        if (empty($data['pet_type']) || empty($data['service_type']) || empty($data['date']) || empty($data['time'])) {
            return $this->jsonResponse(['error' => 'Todos os campos são obrigatórios'], 400);
        }

        $updated = AgendamentoModel::update($id, $data);

        if ($updated) {
            return $this->jsonResponse([
                'message' => 'Agendamento atualizado com sucesso',
                'agendamento' => AgendamentoModel::find($id)
            ]);
        } else {
            return $this->jsonResponse(['error' => 'Erro ao atualizar o agendamento'], 500);
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
