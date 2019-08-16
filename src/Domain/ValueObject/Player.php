<?php

namespace App\Domain\ValueObject;

class Player
{
    /**
     * @var Sign
     */
    private $player;

    /**
     * @var Sign
     */
    private $bot;

    /**
     * @param Sign $playerSign
     */
    public function __construct(Sign $playerSign)
    {
        $this->player = $playerSign;
        $this->bot = $playerSign->getOppositeSign();
    }

    /**
     * @return Sign
     */
    public function getPlayer(): Sign
    {
        return $this->player;
    }

    /**
     * @return Sign
     */
    public function getBot(): Sign
    {
        return $this->bot;
    }
}
