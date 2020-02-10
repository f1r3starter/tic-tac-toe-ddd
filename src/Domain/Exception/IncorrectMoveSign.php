<?php

namespace App\Domain\Exception;

class IncorrectMoveSign extends BadRequestException
{
    /**
     * @var string
     */
    protected $message = 'Sign should be either X or O';
}
