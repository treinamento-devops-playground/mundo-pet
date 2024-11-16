<?php

namespace app\services;

use app\database\repositories\IAgendamentoRepository;
use app\database\models\AgendamentoModel;

class AgendamentoService implements IAgendamentoService
{
    private $agendamentoRepository;

    public function __construct(IAgendamentoRepository $agendamentoRepository)
    {
        $this->agendamentoRepository = $agendamentoRepository;
    }

    public function createAgendamento(array $data)
    {
        $userId = $data['user_id'];
        $petType = $data['pet_type'];
        $serviceType = $data['service_type'];
        $date = $data['date'];
        $time = $data['time'];
        $status = 'ativo';

        if (empty($petType) || empty($serviceType) || empty($date) || empty($time)) {
            throw new \Exception("Por favor, preencha todos os campos.");
        }

        if (!$this->isValidDate($date) || !$this->isValidTime($time)) {
            throw new \Exception("Data ou hora inválida.");
        }

        if (!$this->agendamentoRepository->isAvailable($date, $time, $serviceType)) {
            throw new \Exception("Horário não disponível.");
        }

        $agendamento = new AgendamentoModel($userId, $petType, $serviceType, $date, $time);
        $agendamento->setStatus($status);

        $this->agendamentoRepository->create($agendamento);
    }

    public function getAgendamentoById($id)
    {
        return $this->agendamentoRepository->find($id);
    }

    public function updateAgendamento(AgendamentoModel $agendamento)
    {
        return $this->agendamentoRepository->update($agendamento);
    }

    public function getAgendamentosByUserId($userId)
    {
        return $this->agendamentoRepository->getAgendamentosByUserId($userId);
    }

    public function getUserById($userId)
    {
        return $this->agendamentoRepository->getUserById($userId);
    }

    private function isValidDate($date): bool
    {
        return (bool) strtotime($date);
    }

    private function isValidTime($time): bool
    {
        return (bool) preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $time);
    }
}
