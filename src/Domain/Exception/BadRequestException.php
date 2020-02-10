<?php

namespace App\Domain\Exception;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends InvalidArgumentException
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;
}
