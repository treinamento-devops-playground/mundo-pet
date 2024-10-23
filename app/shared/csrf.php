<?php

use app\shared\support\Csrf;

function getToken()
{
    return Csrf::getToken();
}
