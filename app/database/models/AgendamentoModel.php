<?php

namespace app\database\models;

class AgendamentoModel
{
    private $id;
    private $userId;
    private $petType;
    private $serviceType;
    private $date;
    private $time;
    private $status;
    private $motivoCancelamento;

    public function __construct($userId, $petType, $serviceType, $date, $time)
    {
        $this->userId = $userId;
        $this->petType = $petType;
        $this->serviceType = $serviceType;
        $this->date = $date;
        $this->time = $time;
        $this->status = 'ativo';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getPetType()
    {
        return $this->petType;
    }

    public function getServiceType()
    {
        return $this->serviceType;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getMotivoCancelamento()
    {
        return $this->motivoCancelamento;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setMotivoCancelamento($motivoCancelamento)
    {
        $this->motivoCancelamento = $motivoCancelamento;
    }

    public function setPetType($petType)
    {
        $this->petType = $petType;
    }

    public function setServiceType($serviceType)
    {
        $this->serviceType = $serviceType;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'pet_type' => $this->petType,
            'service_type' => $this->serviceType,
            'date' => $this->date,
            'time' => $this->time,
            'status' => $this->status,
            'motivo_cancelamento' => $this->motivoCancelamento
        ];
    }

    public static function updateStatus($id, $userId)
    {
        $pdo = Connection::getConnection();

        $sql = "UPDATE scheduling SET status = 'finalizado' WHERE id = :id AND user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
