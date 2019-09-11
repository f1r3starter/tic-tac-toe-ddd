<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\IncorrectSign;
use JsonSerializable;

class Sign implements JsonSerializable
{
    public const CROSS = 'X';
    public const ZERO = 'O';
    public const EMPTY = '';
    private const AVAILABLE_VALUES = [self::CROSS, self::ZERO, self::EMPTY];

    /**
     * @var string
     */
    private $sign;

    /**
     * @var self
     */
    private $oppositeSign;

    /**
     * @param string|null $sign
     */
    public function __construct(?string $sign)
    {
        if (!in_array($sign, self::AVAILABLE_VALUES, true)) {
            throw new IncorrectSign();
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

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->sign;
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->getValue();
    }
}
