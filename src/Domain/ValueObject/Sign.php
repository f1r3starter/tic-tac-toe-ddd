<?php

namespace App\Domain\ValueObject;

class Sign
{
    public const CROSS = 'X';
    public const ZERO  = 'O';
    public const EMPTY  = '_';
    private const AVAILABLE_VALUES  = [self::CROSS, self::ZERO, self::EMPTY];

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

        if (self::EMPTY === $sign) {
            $this->oppositeSign = $sign;
        } else {
            $this->oppositeSign = self::CROSS === $sign ? self::ZERO : self::CROSS;
        }
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
    public function getOppositeSign(): string
    {
        return $this->oppositeSign;
    }

    /**
     * @param Sign $sign
     *
     * @return bool
     */
    public function equal(Sign $sign): bool
    {
        return $sign->getValue() === $this->getValue();
    }
}
