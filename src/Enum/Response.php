<?php

namespace MVC\Enum;

use MVC\Enum\Enum;

/**
 * @method static Response HTTP_SERVER_ERROR()
 * @method static Response HTTP_OK()
 * @method static Response HTTP_BAD_REQUEST()
 */
class Response extends Enum
{
    private const HTTP_SERVER_ERROR = 500;
    private const HTTP_OK = 200;
    private const HTTP_BAD_REQUEST = 400;
}