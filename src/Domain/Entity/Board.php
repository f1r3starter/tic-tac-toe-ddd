<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\BoardState;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;

class Board
{
    /**
     * @var Sign|null
     */
    private $winner = null;

    /**
     * @var Sign
     */
    private $playerSign;

    /**
     * @var Sign
     */
    private $lastMove;

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
     * @param Sign $playerSign
     * @param WinnerState|null $winnerState
     */
    public function __construct(BoardState $boardState, Sign $playerSign, ?WinnerState $winnerState = null)
    {
        $players = [$playerSign,  new Sign($playerSign->getOppositeSign())];
        $this->lastMove = $players[array_rand($players)];
        $this->boardState = $boardState;
        $this->playerSign = $playerSign;
        $this->winnerState = $winnerState ?? new WinnerState();
    }

    /**
     * @param Move $move
     * @param Sign $sign
     */
    public function makeMove(Move $move, Sign $sign): void
    {
        if (Sign::EMPTY === $sign->getValue()) {
            throw new \InvalidArgumentException();
        }

        if (!$this->boardState->isEmptySpot($move->getRow(), $move->getColumn())) {
            throw new \InvalidArgumentException();
        }

        $state = $this->boardState->getState();

        $this->lastMove = $sign;

        $state[$move->getRow()][$move->getColumn()] = $sign;
        $this->boardState = new BoardState($state);

        $this->winnerState->makeMove($move, $sign);
        $this->winner = $this->winnerState->hasWinner() ? $sign : null;
    }

    /**
     * @return BoardState
     */
    public function getBoardState(): BoardState
    {
        return $this->boardState;
    }

    /**
     * @return Sign|null
     */
    public function getWinner(): ?Sign
    {
        return $this->winner;
    }

    /**
     * @return Sign
     */
    public function getLastMove(): Sign
    {
        return $this->lastMove;
    }

    public function __clone()
    {
        $this->winnerState = clone $this->winnerState;
    }
}
