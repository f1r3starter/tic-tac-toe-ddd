<?php

namespace App\Domain\ValueObject;

class Move
{
    public const MIN_VALUE = 0;
    public const MAX_VALUE = 2;
    private const LENGTH = 2;

    /**
     * @var int
     */
    private $column;

    /**
     * @var int
     */
    private $row;

    /**
     * @param array $value
     */
    public function __construct(array $value)
    {
        if (\count($value) !== self::LENGTH
            || !$this->inRange($value[0])
            || !$this->inRange($value[1])) {
            throw new \InvalidArgumentException();
        }

        $this->column = $value[0];
        $this->row = $value[1];
    }

    /**
     * @return int
     */
    public function getColumn(): int
    {
        return $this->column;
    }

    /**
     * @return int
     */
    public function getRow(): int
    {
        return $this->row;
    }

    /**
     * @param int $cell
     *
     * @return bool
     */
    private function inRange(int $cell): bool
    {
        return $cell >= self::MIN_VALUE && $cell <= self::MAX_VALUE;
    }
}
