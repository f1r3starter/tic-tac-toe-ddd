<?php

namespace App\Domain\Exception;

class IncorrectBoardState extends \InvalidArgumentException
{
    protected $message = 'You have provided incorrect board  state';
}
