<?php

namespace App\Domain\Exception;

class IncorrectSign extends \InvalidArgumentException
{
    protected $message = 'Incorrect sign value';
}
