<?php

namespace app\controllers\admin;

use app\database\models\AgendamentoModel;
use core\Request;
use app\controllers\BaseController;

class AdminAgendamentoController extends BaseController
{
    public function edit($params)
    {
        $id = $params[0];
        $agendamento = AgendamentoModel::find($id);

        if (!$agendamento) {
            return $this->jsonResponse(['error' => 'Agendamento não encontrado'], 404);
        }

        return $this->view('admin/agendamentos/edit', ['agendamento' => $agendamento]);
    }

    public function update($params)
    {
        $id = $params[0];

        $data = [
            'pet_type' => Request::input('pet_type'),
            'service_type' => Request::input('service_type'),
            'date' => Request::input('date'),
            'time'  => Request::input('time'),
        ];

        $updated = AgendamentoModel::update($id, $data);

        if ($updated) {
            return $this->view('admin/agendamentos/edit', ['message' => 'Agendamento atualizado com sucesso', 'agendamento' => AgendamentoModel::find($id)]);
        } else {
            return $this->view('admin/agendamentos/edit', ['error' => 'Erro ao atualizar o agendamento', 'agendamento' => AgendamentoModel::find($id)]);
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
