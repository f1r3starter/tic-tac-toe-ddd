<?php

namespace App\Domain\Exception;

class IncorrectMoveSign extends BadRequestException
{
    protected $message = 'Sign should be either X or O';
}
