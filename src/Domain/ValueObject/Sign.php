<?php

namespace App\Domain\ValueObject;

class Sign
{
    private const CROSS = 'X';
    private const ZERO  = 'O';
    private const AVAILABLE_VALUES  = [self::CROSS, self::ZERO];

    /**
     * @var string
     */
    private $player;

    /**
     * @var string
     */
    private $bot;

    /**
     * Sign constructor.
     * @param string $playerSign
     */
    public function __construct(string $playerSign)
    {
        if (!in_array($playerSign,  self::AVAILABLE_VALUES,  true)) {
            throw new \InvalidArgumentException();
        }

        $this->player = $playerSign;
        $this->bot = $playerSign === self::CROSS ? self::ZERO : self::CROSS;
    }

    /**
     * @return string
     */
    public function getPlayer(): string
    {
        return $this->player;
    }

    /**
     * @return string
     */
    public function getBot(): string
    {
        return $this->bot;
    }
}
