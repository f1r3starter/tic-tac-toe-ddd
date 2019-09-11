<?php

namespace App\Domain\Exception;

use DomainException;
use Symfony\Component\HttpFoundation\Response;

class GameOver extends DomainException
{
    protected $message = 'Game over, please, start a  new game';
    protected $code = Response::HTTP_PRECONDITION_FAILED;
}
