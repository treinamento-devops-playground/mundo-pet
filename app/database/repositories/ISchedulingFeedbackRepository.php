<?php

namespace app\database\repositories;

use app\database\models\SchedulingFeedbackModel;

interface ISchedulingFeedbackRepository
{
    public function create(SchedulingFeedbackModel $feedback): bool;
}
