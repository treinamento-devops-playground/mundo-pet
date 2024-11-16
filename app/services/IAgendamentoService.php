<?php

namespace app\services;

use app\database\models\AgendamentoModel;

interface IAgendamentoService
{
    public function createAgendamento(array $data);
    public function getAgendamentoById($id);
    public function updateAgendamento(AgendamentoModel $agendamento);
    public function getAgendamentosByUserId($userId);
    public function getUserById($userId);
}
