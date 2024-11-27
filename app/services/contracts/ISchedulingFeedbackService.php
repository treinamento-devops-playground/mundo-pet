<?php

namespace app\services\contracts;

interface ISchedulingFeedbackService
{
    public function createFeedback(array $data);
}
