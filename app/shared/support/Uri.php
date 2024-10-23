<?php

namespace app\shared\support;

class Uri
{

    public static function getUri()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
