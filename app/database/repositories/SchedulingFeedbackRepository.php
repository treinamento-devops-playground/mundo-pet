<?php

namespace app\database\repositories;

use app\database\models\SchedulingFeedbackModel;
use app\database\Connection;
use PDO;

class SchedulingFeedbackRepository implements ISchedulingFeedbackRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
    }

    public function create(SchedulingFeedbackModel $feedback): bool
    {
        $stmt = $this->connection->prepare('
            INSERT INTO scheduling_feedback (scheduling_id, user_id, rating, comment)
            VALUES (:scheduling_id, :user_id, :rating, :comment)
        ');

        $stmt->bindValue(':scheduling_id', $feedback->getSchedulingId());
        $stmt->bindValue(':user_id', $feedback->getUserId());
        $stmt->bindValue(':rating', $feedback->getRating());
        $stmt->bindValue(':comment', $feedback->getComment());

        return $stmt->execute();
    }
}
