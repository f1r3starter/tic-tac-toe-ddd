<?php

namespace App\Domain\Exception;

class SecondMove  extends BadRequestException
{
    protected $message = 'You cannot make move two times in a row';
}
