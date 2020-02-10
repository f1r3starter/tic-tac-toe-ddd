<?php

namespace App\Domain\Exception;

use DomainException;
use Symfony\Component\HttpFoundation\Response;

class GameOver extends DomainException
{
    /**
     * @var string
     */
    protected $message = 'Game over, please, start a  new game';

    /**
     * @var int
     */
    protected $code = Response::HTTP_PRECONDITION_FAILED;
}
