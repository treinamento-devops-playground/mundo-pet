<?php

namespace app\database\models;

class SchedulingFeedbackModel
{
    private int $schedulingId;
    private int $userId;
    private int $rating;
    private ?string $comment;

    public function __construct(int $schedulingId, int $userId, int $rating, ?string $comment)
    {
        $this->schedulingId = $schedulingId;
        $this->userId = $userId;
        $this->rating = $rating;
        $this->comment = $comment;
    }

    public function getSchedulingId(): int
    {
        return $this->schedulingId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
