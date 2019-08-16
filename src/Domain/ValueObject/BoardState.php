<?php

namespace App\Domain\ValueObject;

class BoardState
{
    private const DEFAULT_STATE = [['', '', ''],['', '', ''],['', '', '']];
    private const SIDE_LENGTH = 3;

    /**
     * @var array
     */
    private $state;

    /**
     * @param array|null $state
     */
    public function __construct(array $state = null)
    {
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
