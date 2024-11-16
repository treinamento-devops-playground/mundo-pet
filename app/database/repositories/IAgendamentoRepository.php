<?php

namespace app\database\repositories;

use app\database\models\AgendamentoModel;

interface IAgendamentoRepository
{
    public function create(AgendamentoModel $agendamento): bool;
    public function find($id): ?AgendamentoModel;
    public function update(AgendamentoModel $agendamento): bool;
    public function delete($id): bool;
    public function all(): array;
    public function isAvailable($date, $time, $serviceType): bool;
    public function getAgendamentosByUserId($userId): array;
    public function getUserById($userId);
}
