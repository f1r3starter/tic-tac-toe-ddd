<?php

namespace App\Domain\Exception;

class IncorrectSign extends BadRequestException
{
    /**
     * @var string
     */
    protected $message = 'Incorrect sign value';
}
