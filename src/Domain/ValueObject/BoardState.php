<?php

namespace App\Domain\ValueObject;

class BoardState
{
    public const SIDE_LENGTH = 3;
    public const SIDES = 2;

    /**
     * @var array
     */
    private $state;

    /**
     * @var array
     */
    private $availableMoves;

    /**
     * @param array|null $state
     */
    public function __construct(?array $state = null)
    {
        $state = $state ?? $this->getDefaultState();

        if (!$this->validateBoard($state)) {
            throw new \InvalidArgumentException();
        }

        $this->state = $state;
    }

    /**
     * @return array
     */
    public function getState(): array
    {
        return $this->state;
    }

    /**
     * @return array
     */
    public function getAvailableMoves(): array
    {
        if (empty($this->availableMoves)) {
            $result = [];
            array_walk($this->state, function (array $row, int $rowIndex) use (&$result) {
                array_walk($row, function (Sign $sign, int $columnIndex, int $rowIndex) use (&$result) {
                    if ($sign->equal(new Sign(Sign::EMPTY))) {
                        $result[] = new Move([$columnIndex, $rowIndex]);
                    }
                }, $rowIndex);
            });

            $this->availableMoves = $result;
        }

        return $this->availableMoves;
    }

    public function isEmptySpot(int $row,  int $column): bool
    {
        return $this->state[$row][$column]->equal(new Sign(Sign::EMPTY));
    }

    /**
     * @return array
     */
    private function getDefaultState(): array
    {
        $defaultState = array_map(function () {
            return new Sign(Sign::EMPTY);
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
