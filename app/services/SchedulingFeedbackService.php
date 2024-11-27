<?php

namespace app\services;

use app\services\contracts\ISchedulingFeedbackService;
use app\database\repositories\ISchedulingFeedbackRepository;
use app\database\models\SchedulingFeedbackModel;

class SchedulingFeedbackService implements ISchedulingFeedbackService
{
    private ISchedulingFeedbackRepository $feedbackRepository;

    public function __construct(ISchedulingFeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    public function createFeedback(array $data)
    {
        $schedulingId = $data['scheduling_id'];
        $userId = $data['user_id'];
        $rating = $data['rating'];
        $comment = $data['comment'];

        if (empty($comment)) {
            throw new \Exception("Por favor, preencha a avaliação");
        }

        $feedback = new SchedulingFeedbackModel($schedulingId, $userId, $rating, $comment);
        $this->feedbackRepository->create($feedback);
    }
}
