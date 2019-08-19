<?php

namespace App\Domain\Exception;

class GameOver  extends \DomainException
{
    protected $message = 'Game over, please, start a  new game';
}
