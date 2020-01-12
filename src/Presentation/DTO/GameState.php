<?php

namespace App\Presentation\DTO;

use App\Domain\Entity\Board;
use App\Domain\ValueObject\Sign;

class GameState
{
    /**
     * @var Sign[][]
     */
    private $boardState;

    /**
     * @var string
     */
    private $nextMove;

    /**
     * @var bool
     */
    private $isOver;

    /**
     * @var string
     */
    private $playerSign;

    /**
     * @var string
     */
    private $winner;

    /**
     * @param Board $board
     */
    public function __construct(Board $board)
    {
        $this->boardState = $board->getBoardState()->getState();
        $this->nextMove = $board->getLastMove()->getOppositeSign();
        $this->isOver = $board->isGameOver();
        $this->winner = $board->getWinner() ? $board->getWinner()->getValue() : null;
        $this->playerSign = $board->getPlayerSign()->getValue();
    }

    /**
     * @return Sign[][]
     */
    public function getBoardState(): array
    {
        return $this->boardState;
    }

    /**
     * @return string
     */
    public function getNextMove(): string
    {
        return $this->nextMove;
    }

    /**
     * @return bool
     */
    public function isOver(): bool
    {
        return $this->isOver;
    }

    /**
     * @return string
     */
    public function getPlayerSign(): string
    {
        return $this->playerSign;
    }

    /**
     * @return string|null
     */
    public function getWinner(): ?string
    {
        return $this->winner;
    }
}
