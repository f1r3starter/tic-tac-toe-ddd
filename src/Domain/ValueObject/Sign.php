<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\IncorrectSign;

class Sign
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
     * @var string
     */
    private $oppositeSign;

    /**
     * @param string|null $sign
     */
    public function __construct(?string $sign = self::EMPTY)
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
     * @return bool
     */
    public function isEmpty(): bool
    {
        return self::EMPTY === $this->sign;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->sign;
    }
}
