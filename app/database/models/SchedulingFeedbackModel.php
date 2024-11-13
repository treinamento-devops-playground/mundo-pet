<?php

namespace app\database\models;

use PDO;
use app\database\Connection;

class SchedulingFeedbackModel
{
    public static function create($schedulingId, $userId, $rating, $comment)
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare("INSERT INTO scheduling_feedback (scheduling_id, user_id, rating, comment) VALUES (:scheduling_id, :user_id, :rating, :comment)");
        $stmt->bindValue(':scheduling_id', $schedulingId);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':rating', $rating);
        $stmt->bindValue(':comment', $comment);
        $stmt->execute();
    }
}
