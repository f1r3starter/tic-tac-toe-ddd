<?php

namespace App\Domain\Exception;

class IncorrectSign extends BadRequestException
{
    protected $message = 'Incorrect sign value';
}
