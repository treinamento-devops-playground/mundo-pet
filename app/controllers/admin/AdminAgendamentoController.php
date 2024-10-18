<?php

namespace app\controllers;

use app\database\models\Agendamento;
use core\Request;
use app\controllers\ContainerController;

class AgendamentoController extends ContainerController
{
    public function edit($params)
    {
        $id = $params[0];
        $agendamento = Agendamento::find($id);

        if (!$agendamento) {
            return $this->jsonResponse(['error' => 'Agendamento não encontrado'], 404);
        }

        return $this->jsonResponse($agendamento);
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

        $updated = Agendamento::update($id, $data);

        if ($updated) {
            return $this->jsonResponse(['message' => 'Agendamento atualizado com sucesso']);
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
