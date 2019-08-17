<?php

namespace App\Domain\ValueObject;

class Sign
{
    public const CROSS = 'X';
    public const ZERO  = 'O';
    public const EMPTY  = '';
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
            $this->oppositeSign = new self($sign);
        } else {
            $oppositeSign = self::CROSS === $sign ? self::ZERO : self::CROSS;
            $this->oppositeSign = new self($oppositeSign);
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
    public function getOppositeSign(): self
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
