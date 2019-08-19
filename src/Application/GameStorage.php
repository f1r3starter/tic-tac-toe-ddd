<?php

namespace App\Application;

use App\Domain\Entity\Board;

interface GameStorage
{
    /**
     * @param Board $board
     */
    public function saveGameState(Board $board): void;

    /**
     * @return Board
     */
    public function restoreGameState(): Board;

    public function restartGame(): void;

    /**
     * @return bool
     */
    public function gameStarted(): bool;
}
