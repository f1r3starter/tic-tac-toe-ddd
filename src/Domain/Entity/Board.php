<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\BoardState;
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
    private $state;

    /**
     * Board constructor.
     * @param BoardState $state
     * @param Player $player
     */
    public function __construct(BoardState $state, Player $player)
    {
        $this->state = $state;
        $this->player = $player;
    }
}
