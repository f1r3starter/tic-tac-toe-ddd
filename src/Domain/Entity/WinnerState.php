<?php

namespace App\Domain\Entity;

use App\Domain\Exception\IncorrectMoveSign;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;
use function array_fill;
use function in_array;

class WinnerState
{
    private const CROSS_INDEX = 0;
    private const ZERO_INDEX = 1;
    private const INIT_VALUE = [0, 0];

    /**
     * @var int[][]
     */
    private $columns;

    /**
     * @var int[][]
     */
    private $rows;

    /**
     * @var int[][]
     */
    private $diagonal;

    /**
     * @var int[][]
     */
    private $oppositeDiagonal;

    /**
     * @var bool
     */
    private $hasWinner = false;

    public function __construct()
    {
        $defaultValue = $this->initSide();

        $this->columns = $defaultValue;
        $this->rows = $defaultValue;
        $this->diagonal = self::INIT_VALUE;
        $this->oppositeDiagonal = self::INIT_VALUE;
    }

    /**
     * @return int[][]
     */
    private function initSide(): array
    {
        return array_fill(0, BoardState::SIDE_LENGTH, self::INIT_VALUE);
    }

    /**
     * @param Move $move
     * @param Sign $sign
     */
    public function makeMove(Move $move, Sign $sign): void
    {
        if ($sign->isEmpty()) {
            throw new IncorrectMoveSign();
        }

        $index = Sign::CROSS === $sign->getValue() ? self::CROSS_INDEX : self::ZERO_INDEX;

        $sidesStates = [
            $this->updateColumn($move->getColumn(), $index),
            $this->updateRow($move->getRow(), $index),
            $this->updateDiagonal($move->getColumn(), $move->getRow(), $index),
            $this->updateOppositeDiagonal($move->getColumn(), $move->getRow(), $index),
        ];

        $this->hasWinner = in_array(BoardState::SIDE_LENGTH, $sidesStates, true);
    }

    /**
     * @param int $columnIndex
     * @param int $signIndex
     *
     * @return int
     */
    private function updateColumn(int $columnIndex, int $signIndex): int
    {
        return ++$this->columns[$columnIndex][$signIndex];
    }

    /**
     * @param int $rowIndex
     * @param int $signIndex
     *
     * @return int
     */
    private function updateRow(int $rowIndex, int $signIndex): int
    {
        return ++$this->rows[$rowIndex][$signIndex];
    }

    /**
     * @param int $columnIndex
     * @param int $rowIndex
     * @param int $signIndex
     *
     * @return int
     */
    private function updateDiagonal(int $columnIndex, int $rowIndex, int $signIndex): int
    {
        return $columnIndex === $rowIndex ? ++$this->diagonal[$signIndex] : $this->diagonal[$signIndex];
    }

    /**
     * @param int $columnIndex
     * @param int $rowIndex
     * @param int $signIndex
     *
     * @return int
     */
    private function updateOppositeDiagonal(int $columnIndex, int $rowIndex, int $signIndex): int
    {
        return $columnIndex === BoardState::SIDE_LENGTH - $rowIndex - 1 ? ++$this->oppositeDiagonal[$signIndex] : $this->oppositeDiagonal[$signIndex];
    }

    /**
     * @return bool
     */
    public function hasWinner(): bool
    {
        return $this->hasWinner;
    }
}
