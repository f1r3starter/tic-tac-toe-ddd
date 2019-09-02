<?php

namespace App\Presentation\DTO;

use App\Domain\Entity\Board;

class GameState implements \JsonSerializable
{
    /**
     * @var array
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
        $this->winner = $board->getWinner();
        $this->playerSign = $board->getPlayerSign()->getValue();
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'boardState' => $this->boardState,
            'nextMove' => $this->nextMove,
            'isOver' => $this->isOver,
            'playerSign' => $this->playerSign,
            'winner' =>  $this->winner,
        ];
    }
}
