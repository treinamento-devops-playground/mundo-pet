<?php

namespace app\database\repositories;

use app\database\models\AgendamentoModel;
use app\database\Connection;
use PDO;

class AgendamentoRepository implements IAgendamentoRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
    }

    public function create(AgendamentoModel $agendamento): bool
    {
        $stmt = $this->connection->prepare('
            INSERT INTO scheduling (user_id, pet_type, service_type, date, time, status)
            VALUES (:user_id, :pet_type, :service_type, :date, :time, :status)
        ');

        $stmt->bindValue(':user_id', $agendamento->getUserId());
        $stmt->bindValue(':pet_type', $agendamento->getPetType());
        $stmt->bindValue(':service_type', $agendamento->getServiceType());
        $stmt->bindValue(':date', $agendamento->getDate());
        $stmt->bindValue(':time', $agendamento->getTime());
        $stmt->bindValue(':status', $agendamento->getStatus());

        return $stmt->execute();
    }

    public function find($id): ?AgendamentoModel
    {
        $stmt = $this->connection->prepare('SELECT * FROM scheduling WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return $this->mapToModel($data);
        }

        return null;
    }

    public function update(AgendamentoModel $agendamento): bool
    {
        $stmt = $this->connection->prepare('
            UPDATE scheduling SET
                user_id = :user_id,
                pet_type = :pet_type,
                service_type = :service_type,
                date = :date,
                time = :time,
                status = :status,
                motivo_cancelamento = :motivo_cancelamento
            WHERE id = :id
        ');

        $stmt->bindValue(':user_id', $agendamento->getUserId());
        $stmt->bindValue(':pet_type', $agendamento->getPetType());
        $stmt->bindValue(':service_type', $agendamento->getServiceType());
        $stmt->bindValue(':date', $agendamento->getDate());
        $stmt->bindValue(':time', $agendamento->getTime());
        $stmt->bindValue(':status', $agendamento->getStatus());
        $stmt->bindValue(':id', $agendamento->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':motivo_cancelamento', $agendamento->getMotivoCancelamento());

        return $stmt->execute();
    }

    public function delete($id): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM scheduling WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function all(): array
    {
        $stmt = $this->connection->query('SELECT * FROM scheduling');
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $agendamentos = [];
        foreach ($data as $item) {
            $agendamentos[] = $this->mapToModel($item);
        }

        return $agendamentos;
    }

    public function isAvailable($date, $time, $serviceType): bool
    {
        $stmt = $this->connection->prepare('
            SELECT COUNT(*) FROM scheduling
            WHERE date = :date AND time = :time AND service_type = :service_type AND status = "ativo"
        ');
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':time', $time);
        $stmt->bindValue(':service_type', $serviceType);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count == 0;
    }

    public function getUserById($userId)
    {
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAgendamentosByUserId($userId): array
    {
        $stmt = $this->connection->prepare('SELECT * FROM scheduling WHERE user_id = :user_id');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $agendamentos = [];
        foreach ($data as $item) {
            $agendamentos[] = $this->mapToModel($item);
        }

        return $agendamentos;
    }

    private function mapToModel(array $data): AgendamentoModel
    {
        $agendamento = new AgendamentoModel(
            $data['user_id'],
            $data['pet_type'],
            $data['service_type'],
            $data['date'],
            $data['time']
        );
        $agendamento->setId($data['id']);
        $agendamento->setStatus($data['status']);
        $agendamento->setMotivoCancelamento($data['motivo_cancelamento']);
        return $agendamento;
    }
}
