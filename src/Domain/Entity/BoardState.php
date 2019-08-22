<?php

namespace App\Domain\Entity;

use App\Domain\Exception\CellIsOccupied;
use App\Domain\Exception\IncorrectBoardState;
use App\Domain\Exception\IncorrectMoveSign;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;

class BoardState implements \Serializable
{
    public const SIDE_LENGTH = 3;
    public const SIDES = 2;

    /**
     * @var array
     */
    private $state;

    /**
     * @var Move[]
     */
    private $availableMoves;

    /**
     * @var Sign
     */
    private $emptySign;

    /**
     * @param array|null $state
     */
    public function __construct(?array $state = null)
    {
        $this->emptySign =  new Sign(Sign::EMPTY);
        $state = $state ?? $this->getDefaultState();

        if (!$this->validateBoard($state)) {
            throw new IncorrectBoardState();
        }

        $this->state = $state;

        $availableMoves = [];
        array_walk($this->state, function (array $row, int $rowIndex) use (&$availableMoves) {
            array_walk($row, function (Sign $sign, int $columnIndex, int $rowIndex) use (&$availableMoves) {
                if ($sign->equal($this->emptySign)) {
                    $availableMoves[$rowIndex][$columnIndex] = new Move($rowIndex, $columnIndex);
                }
            }, $rowIndex);
        });

        $this->availableMoves = $availableMoves;
    }

    /**
     * @return array
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
        if (Sign::EMPTY === $sign->getValue()) {
            throw new IncorrectMoveSign();
        }

        if (!$this->isEmptySpot($move->getRow(), $move->getColumn())) {
            throw new CellIsOccupied();
        }

        unset($this->availableMoves[$move->getRow()][$move->getColumn()]);

        $this->state[$move->getRow()][$move->getColumn()] =  $sign;
    }

    /**
     * @return Move[]
     */
    public function getAvailableMoves(): array
    {
        return array_merge(...$this->availableMoves);
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize([
            $this->state,
            $this->availableMoves,
        ]);
    }

    /**
     * @param $serialized
     *
     * @return void
     */
    public function unserialize($serialized): void
    {
        list(
            $this->state,
            $this->availableMoves,
        ) = unserialize($serialized);

        $this->emptySign = new Sign(Sign::EMPTY);
    }

    /**
     * @param int $row
     * @param int $column
     *
     * @return bool
     */
    private function isEmptySpot(int $row, int $column): bool
    {
        return $this->state[$row][$column]->equal($this->emptySign);
    }

    /**
     * @return array
     */
    private function getDefaultState(): array
    {
        $defaultState = array_map(function () {
            return clone $this->emptySign;
        },  array_fill(0, pow(self::SIDE_LENGTH, self::SIDES), null));

        return array_chunk($defaultState, self::SIDE_LENGTH);
    }

    /**
     * @param array $state
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
}
