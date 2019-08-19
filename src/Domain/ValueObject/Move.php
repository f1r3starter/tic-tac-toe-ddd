<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\MoveIsOutOfRange;

class Move
{
    public const MIN_VALUE = 0;
    public const MAX_VALUE = 2;

    /**
     * @var int
     */
    private $column;

    /**
     * @var int
     */
    private $row;

    /**
     * @param int $row
     * @param int $column
     */
    public function __construct(int $row, int $column)
    {
        if ($this->outOfRange($row) || $this->outOfRange($column)) {
            throw new MoveIsOutOfRange();
        }

        $this->column = $column;
        $this->row = $row;
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
    private function outOfRange(int $cell): bool
    {
        return $cell < self::MIN_VALUE && $cell > self::MAX_VALUE;
    }
}
