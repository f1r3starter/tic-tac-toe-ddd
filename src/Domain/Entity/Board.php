<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\BoardState;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Player;
use App\Domain\ValueObject\Sign;

class Board
{
    /**
     * @var Sign|null
     */
    private $winner = null;

    /**
     * @var Player
     */
    private $player;

    /**
     * @var BoardState
     */
    private $boardState;

    /**
     * @var WinnerState
     */
    private $winnerState;

    /**
     * @param BoardState $boardState
     * @param Player $player
     * @param WinnerState|null $winnerState
     */
    public function __construct(BoardState $boardState, Player $player, ?WinnerState $winnerState = null)
    {
        $this->boardState = $boardState;
        $this->player = $player;
        $this->winnerState = $winnerState ?? new WinnerState();
    }

    /**
     * @param Move $move
     * @param Sign $sign
     */
    public function makeMove(Move $move, Sign $sign): void
    {
        $state = $this->boardState->getState();
        if (Sign::EMPTY !== $state[$move->getRow()][$move->getColumn()]) {
            throw new \InvalidArgumentException();
        }
        $state[$move->getRow()][$move->getColumn()] = $sign;
        $this->boardState = new BoardState($state);

        $this->winnerState->makeMove($move, $sign);
        $this->winner = $this->winnerState->hasWinner() ? $sign : null;
    }

    /**
     * @return Sign|null
     */
    public function getWinner(): ?Sign
    {
        return $this->winner;
    }
}
