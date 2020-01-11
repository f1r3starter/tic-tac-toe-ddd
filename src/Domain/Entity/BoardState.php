<?php

namespace App\Domain\Entity;

use App\Domain\Exception\CellIsOccupied;
use App\Domain\Exception\IncorrectBoardState;
use App\Domain\Exception\IncorrectMoveSign;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;

class BoardState
{
    public const SIDE_LENGTH = 3;
    public const SIDES = 2;

    /**
     * @var Sign[][]
     */
    private $state;

    /**
     * @var Move[][]
     */
    private $availableMoves;

    /**
     * @param Sign[][]|null $state
     */
    public function __construct(?array $state = null)
    {
        $this->state = null === $state ? $this->getDefaultState() : $this->prepareState($state);

        $availableMoves = [];
        array_walk($this->state, static function (array $row, int $rowIndex) use (&$availableMoves) {
            array_walk($row, static function (Sign $sign, int $columnIndex, int $rowIndex) use (&$availableMoves) {
                if ($sign->isEmpty()) {
                    $availableMoves[$rowIndex][$columnIndex] = new Move($rowIndex, $columnIndex);
                }
            }, $rowIndex);
        });

        $this->availableMoves = $availableMoves;
    }

    /**
     * @return Sign[][]
     */
    public function getState(): array
    {
        return $this->state;
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

        if (!$this->isEmptySpot($move->getRow(), $move->getColumn())) {
            throw new CellIsOccupied();
        }

        unset($this->availableMoves[$move->getRow()][$move->getColumn()]);

        $this->state[$move->getRow()][$move->getColumn()] = $sign;
    }

    /**
     * @return Move[]
     */
    public function getAvailableMoves(): array
    {
        return empty($this->availableMoves) ? [] : array_merge(...$this->availableMoves);
    }

    /**
     * @param Sign[][] $state
     *
     * @return bool
     */
    private function validateBoard(array $state): bool
    {
        $columnsLengths = array_map('count', $state);

        return count($state) === self::SIDE_LENGTH
            && count(array_unique($columnsLengths))
            && end($columnsLengths) === self::SIDE_LENGTH; // This is what happened when you hate to use loops :)
    }

    /**
     * @param int $row
     * @param int $column
     *
     * @return bool
     */
    private function isEmptySpot(int $row, int $column): bool
    {
        return $this->state[$row][$column]->isEmpty();
    }

    /**
     * @param Sign[][] $state
     *
     * @return Sign[][]
     */
    private function prepareState(array $state): array
    {
        if (!$this->validateBoard($state)) {
            throw new IncorrectBoardState();
        }

        return array_map(static function(array $row) {
            return array_map(static function($sign) {
                return $sign instanceof Sign ? $sign : new Sign($sign['sign']);
            }, $row);
        }, $state);
    }

    /**
     * @return Sign[][]
     */
    private function getDefaultState(): array
    {
        $defaultState = array_map(static function() {
            return new Sign(Sign::EMPTY);
        }, array_fill(0, self::SIDE_LENGTH ** self::SIDES, null));

        return array_chunk($defaultState, self::SIDE_LENGTH);
    }
}
