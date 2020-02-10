<?php

namespace App\Domain\Exception;

class IncorrectBoardState extends BadRequestException
{
    /**
     * @var string
     */
    protected $message = 'You have provided incorrect board  state';
}
