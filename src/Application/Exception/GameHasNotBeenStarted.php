<?php

namespace App\Application\Exception;

use LogicException;
use Symfony\Component\HttpFoundation\Response;

class GameHasNotBeenStarted extends LogicException
{
    protected $message = 'Game has not been started';
    protected $code = Response::HTTP_PRECONDITION_REQUIRED;
}
