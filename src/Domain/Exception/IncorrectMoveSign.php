<?php

namespace App\Domain\Exception;

class IncorrectMoveSign  extends \InvalidArgumentException
{
    protected $message = 'Sign should be either X or O';
}
