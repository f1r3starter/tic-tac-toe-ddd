<?php

namespace App\Domain\Service;

use App\Domain\Entity\Board;

interface BotStrategy
{
    public function makeMove(Board $board): void;
}
