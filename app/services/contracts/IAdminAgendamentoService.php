<?php

namespace app\services\contracts;

interface IAdminAgendamentoService
{
    public function getAgendamentos();
    public function getAgendamentoById($id);
    public function updateAgendamento($id, array $data);
}
