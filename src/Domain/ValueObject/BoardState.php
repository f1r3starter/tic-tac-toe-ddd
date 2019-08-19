<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\IncorrectBoardState;

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
                    if ($sign->equal($this->emptySign)) {
                        $result[] = new Move($rowIndex, $columnIndex);
                    }
                }, $rowIndex);
            });

            $this->availableMoves = $result;
        }

        return $this->availableMoves;
    }

    public function isEmptySpot(int $row, int $column): bool
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
