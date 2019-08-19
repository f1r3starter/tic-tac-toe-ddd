<?php

namespace App\Domain\Exception;

class MoveIsOutOfRange extends \OutOfBoundsException
{
    protected $message = 'Move is out of acceptable range';
}
