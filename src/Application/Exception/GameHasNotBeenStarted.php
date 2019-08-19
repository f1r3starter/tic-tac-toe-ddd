<?php

namespace App\Application\Exception;

class GameHasNotBeenStarted extends \LogicException
{
    protected $message = 'Game has not been started';
}
