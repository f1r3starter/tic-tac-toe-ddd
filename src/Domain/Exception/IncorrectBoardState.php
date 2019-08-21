<?php

namespace App\Domain\Exception;

class IncorrectBoardState extends BadRequestException
{
    protected $message = 'You have provided incorrect board  state';
}
