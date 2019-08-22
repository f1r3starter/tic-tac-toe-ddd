<?php

namespace App\Domain\Entity;

use App\Domain\Exception\GameOver;
use App\Domain\Exception\SecondMove;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;

class Board implements \Serializable
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
     * @param Sign $playerSign
     * @param BoardState|null $boardState
     * @param WinnerState|null $winnerState
     */
    public function __construct(Sign $playerSign, ?BoardState $boardState = null, ?WinnerState $winnerState = null)
    {
        $players = [$playerSign,  new Sign($playerSign->getOppositeSign())];
        $this->lastMove = $players[array_rand($players)];
        $this->boardState = $boardState ?? new BoardState();
        $this->playerSign = $playerSign;
        $this->winnerState = $winnerState ?? new WinnerState();
    }

    /**
     * @param Move $move
     * @param Sign $sign
     */
    public function makeMove(Move $move, Sign $sign): void
    {
        if ($this->getLastMove()->equal($sign)) {
            throw new SecondMove();
        }

        if ($this->isGameOver()) {
            throw new GameOver();
        }

        $this->boardState->makeMove($move, $sign);
        $this->winnerState->makeMove($move, $sign);
        $this->lastMove = $sign;

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

    /**
     * @return Sign
     */
    public function getPlayerSign(): Sign
    {
        return $this->playerSign;
    }

    /**
     * @return bool
     */
    public function isGameOver(): bool
    {
        return empty($this->getBoardState()->getAvailableMoves()) || null !== $this->winner;
    }

    public function __clone()
    {
        $this->winnerState = clone $this->winnerState;
        $this->boardState = clone $this->boardState;
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize([
            $this->winner ? $this->winner->getValue() : null,
            $this->playerSign->getValue(),
            $this->lastMove->getValue(),
            serialize($this->boardState),
            serialize($this->winnerState),
        ]);
    }

    /**
     * @param $serialized
     *
     * @return void
     */
    public function unserialize($serialized): void
    {
        list(
            $winner,
            $playerSign,
            $lastMove,
            $boardState,
            $winnerState,
            ) = unserialize($serialized);

        $this->winner = $winner ? new Sign($winner) : $winner;
        $this->playerSign = new Sign($playerSign);
        $this->lastMove = new Sign($lastMove);
        $this->boardState = unserialize($boardState);
        $this->winnerState = unserialize($winnerState);
    }
}
