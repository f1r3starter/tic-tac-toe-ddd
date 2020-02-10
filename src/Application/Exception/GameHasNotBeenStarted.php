<?php

namespace App\Application\Exception;

use LogicException;
use Symfony\Component\HttpFoundation\Response;

class GameHasNotBeenStarted extends LogicException
{
    /**
     * @var string
     */
    protected $message = 'Game has not been started';

    /**
     * @var int
     */
    protected $code = Response::HTTP_PRECONDITION_REQUIRED;
}
