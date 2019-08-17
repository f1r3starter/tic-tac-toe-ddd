<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\BoardState;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;

class WinnerState
{
    private const CROSS_INDEX = 0;
    private const O_INDEX = 1;

    /**
     * @var array
     */
    private $columns = [];

    /**
     * @var array
     */
    private $rows = [];

    /**
     * @var array
     */
    private $diagonal = [];

    /**
     * @var array
     */
    private $oppositeDiagonal = [];

    /**
     * @var bool
     */
    private $hasWinner = false;

    public function __construct()
    {
        $defaultValue = $this->initSide();

        $this->columns = $defaultValue;
        $this->rows = $defaultValue;
        $this->diagonal = $defaultValue;
        $this->oppositeDiagonal = $defaultValue;
    }

    /**
     * @param Move $move
     * @param Sign $sign
     */
    public function makeMove(Move $move, Sign $sign): void
    {
        if (Sign::EMPTY !== $sign->getValue()) {
            $index = Sign::CROSS === $sign->getValue() ? self::CROSS_INDEX : self::O_INDEX;

            $sidesStates = [
                $this->updateColumn($move->getColumn(), $index),
                $this->updateRow($move->getRow(), $index),
                $this->updateDiagonal($move->getColumn(), $move->getRow(), $index),
                $this->updateOppositeDiagonal($move->getColumn(), $move->getRow(), $index),
            ];

            $this->hasWinner = in_array(BoardState::SIDE_LENGTH, $sidesStates, true);
        }
    }

    /**
     * @return bool
     */
    public function hasWinner(): bool
    {
        return $this->hasWinner();
    }

    /**
     * @return array
     */
    private function initSide():  array
    {
        return array_fill(0, BoardState::SIDE_LENGTH, [0, 0]);
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
        return $columnIndex === $rowIndex ? ++$this->diagonal[$columnIndex] : $this->diagonal[$rowIndex];
    }

    private function updateOppositeDiagonal(int $columnIndex, int $rowIndex, int $signIndex): int
    {
        return $columnIndex ===  BoardState::SIDE_LENGTH - $rowIndex ? ++$this->oppositeDiagonal[$columnIndex] : $this->oppositeDiagonal[$columnIndex];
    }
}
