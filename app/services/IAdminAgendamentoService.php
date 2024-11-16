<?php

namespace app\services;

interface IAdminAgendamentoService
{
    public function getAgendamentos();
    public function getAgendamentoById($id);
    public function updateAgendamento($id, array $data);
    //public function changeStatus($id, $status);
}
