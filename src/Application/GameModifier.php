<?php

namespace App\Application;

use App\Application\Exception\GameHasNotBeenStarted;
use App\Domain\Entity\Board;
use App\Domain\Strategy\BotStrategy;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;

class GameModifier
{
    /**
     * @var GameStorage
     */
    private $gameStorage;

    /**
     * @var BotStrategy
     */
    private $botStrategy;

    /**
     * @param GameStorage $gameStorage
     * @param BotStrategy $botStrategy
     */
    public function __construct(GameStorage $gameStorage, BotStrategy $botStrategy)
    {
        $this->gameStorage = $gameStorage;
        $this->botStrategy = $botStrategy;
    }

    /**
     * @return Board
     */
    public function getState(): Board
    {
        if ($this->gameStorage->gameStarted()) {
            return $this->gameStorage->restoreGameState();
        }

        throw new GameHasNotBeenStarted();
    }

    /**
     * @param int $row
     * @param int $column
     *
     * @return Board
     */
    public function makeMove(int $row, int $column): Board
    {
        if (!$this->gameStorage->gameStarted()) {
            throw new GameHasNotBeenStarted();
        }

        $move = new Move($row, $column);
        $board = $this->gameStorage->restoreGameState();
        $board->makeMove($move, $board->getPlayerSign());
        $botSign = new Sign($board->getPlayerSign()->getOppositeSign());
        $this->botStrategy->makeMove($board, $botSign);
        $this->gameStorage->saveGameState($board);

        return $board;
    }

    /**
     * @param string|null $sign
     *
     * @return Board
     */
    public function chooseSign(?string $sign): Board
    {
        $this->gameStorage->restartGame();

        $playerSign = new Sign($sign);
        $botSign = new Sign($playerSign->getOppositeSign());
        $board = new Board(
            $playerSign
        );

        if ($board->getLastMove()->equal($playerSign)) {
            $this->botStrategy->makeMove($board, $botSign);
        }

        $this->gameStorage->saveGameState($board);

        return $board;
    }
}
