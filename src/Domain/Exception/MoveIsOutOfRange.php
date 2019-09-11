<?php

namespace App\Domain\Exception;

use OutOfBoundsException;
use Symfony\Component\HttpFoundation\Response;

class MoveIsOutOfRange extends OutOfBoundsException
{
    protected $message = 'Move is out of acceptable range';
    protected $code = Response::HTTP_BAD_REQUEST;
}
