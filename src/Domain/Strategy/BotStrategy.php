<?php

namespace App\Domain\Strategy;

use App\Domain\Entity\Board;
use App\Domain\ValueObject\Sign;

interface BotStrategy
{
    /**
     * @param Board $board
     * @param Sign $botSign
     */
    public function makeMove(Board $board, Sign $botSign): void;
}
