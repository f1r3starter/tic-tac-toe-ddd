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
    private $sign;

    /**
     * @var self
     */
    private $oppositeSign;

    /**
     * @param string $sign
     */
    public function __construct(string $sign)
    {
        if (!in_array($sign,  self::AVAILABLE_VALUES,  true)) {
            throw new \InvalidArgumentException();
        }

        $this->sign = $sign;
        $oppositeSign = $sign === self::CROSS ?  self::ZERO : self::CROSS;
        $this->oppositeSign = new self($oppositeSign);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->sign;
    }

    /**
     * @return Sign
     */
    public function getOppositeSign(): self
    {
        return $this->oppositeSign;
    }
}
