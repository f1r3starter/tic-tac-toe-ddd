<?php

namespace App\Domain\Exception;

use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends \InvalidArgumentException
{
    protected $code = Response::HTTP_BAD_REQUEST;
}
