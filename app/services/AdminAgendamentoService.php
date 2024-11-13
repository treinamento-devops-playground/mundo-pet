<?php

namespace app\services;

use app\database\models\AgendamentoModel;

class AdminAgendamentoService
{
    private AgendamentoModel $agendamentoModel;

    public function __construct()
    {
        $this->agendamentoModel = new AgendamentoModel();
    }

    public function getAgendamentos()
    {
        return $this->agendamentoModel->all();
    }

    public function getAgendamentoById($id)
    {
        return $this->agendamentoModel->find($id);
    }

    public function updateAgendamento($id, $data)
    {
        if (!is_numeric($id)) {
            throw new \Exception('ID inválido');
        }

        $agendamento = $this->agendamentoModel->find($id);
        if (!$agendamento) {
            throw new \Exception('Agendamento não encontrado');
        }

        if (!$this->isValidDate($data['date'])) {
            throw new \Exception('Data inválida');
        }

        if (!$this->isValidTime($data['time'])) {
            throw new \Exception('Hora inválida');
        }

        /*if ($this->hasScheduleConflict($data['date'], $data['time'], $id)) {
            throw new \Exception('Horário já ocupado');
        }*/

        return $this->agendamentoModel->update($id, $data);
    }

    private function isValidDate($date): bool
    {
        return (bool) strtotime($date);
    }

    private function isValidTime($time): bool
    {
        return (bool) preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $time);
    }

    /*private function hasScheduleConflict($date, $time){
        //depois tenho que criar a lógica para verificar os conflitos de horário de agendamento
    }*/
}
