<?php

namespace App\Domain\Exception;

use OutOfBoundsException;
use Symfony\Component\HttpFoundation\Response;

class MoveIsOutOfRange extends OutOfBoundsException
{
    /**
     * @var string
     */
    protected $message = 'Move is out of acceptable range';

    /**
     * @var int
     */
    protected $code = Response::HTTP_BAD_REQUEST;
}
