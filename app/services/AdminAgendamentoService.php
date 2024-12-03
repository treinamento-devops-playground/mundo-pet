<?php

namespace app\services;

use app\services\contracts\IAdminAgendamentoService;
use app\database\repositories\IAgendamentoRepository;
use app\database\models\AgendamentoModel;

class AdminAgendamentoService implements IAdminAgendamentoService
{
    private $agendamentoRepository;

    public function __construct(IAgendamentoRepository $agendamentoRepository)
    {
        $this->agendamentoRepository = $agendamentoRepository;
    }

    public function getAgendamentos()
    {
        return $this->agendamentoRepository->all();
    }

    public function getAgendamentoById($id)
    {
        return $this->agendamentoRepository->find($id);
    }

    public function updateAgendamento($id, array $data)
    {
        if (!is_numeric($id)) {
            throw new \Exception('ID inválido');
        }

        $agendamento = $this->agendamentoRepository->find($id);

        if (!$agendamento) {
            throw new \Exception('Agendamento não encontrado');
        }

        if (isset($data['date']) && !$this->isValidDate($data['date'])) {
            throw new \Exception('Data inválida');
        }

        if (isset($data['time']) && !$this->isValidTime($data['time'])) {
            throw new \Exception('Hora inválida');
        }

        if (isset($data['pet_type'])) {
            $agendamento->setPetType($data['pet_type']);
        }

        if (isset($data['service_type'])) {
            $agendamento->setServiceType($data['service_type']);
        }

        if (isset($data['date'])) {
            $agendamento->setDate($data['date']);
        }

        if (isset($data['time'])) {
            $agendamento->setTime($data['time']);
        }

        if (isset($data['status'])) {
            $validStatuses = ['ativo', 'cancelado', 'concluído'];

            if (!in_array($data['status'], $validStatuses)) {
                throw new \Exception('Status inválido');
            }

            $agendamento->setStatus($data['status']);
        }

        $success = $this->agendamentoRepository->update($agendamento);

        if ($success) {
            return $agendamento;
        } else {
            throw new \Exception('Erro ao atualizar agendamento');
        }
    }

    private function isValidDate($date): bool
    {
        return (bool) strtotime($date);
    }

    private function isValidTime($time): bool
    {
        return (bool) preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $time);
    }
}
