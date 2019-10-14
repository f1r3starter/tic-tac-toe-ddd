<?php

namespace App\Tests\Unit\Presentation\DTO;

use App\Domain\Entity\Board;
use App\Domain\ValueObject\Sign;
use App\Presentation\DTO\GameState;
use PHPUnit\Framework\TestCase;

class GameStateTest extends TestCase
{
    public function testSerialize(): void
    {
        $board = new Board(
            new Sign(Sign::CROSS)
        );

        $gameState = new GameState($board);

        $this->assertEquals($board->getBoardState()->getState(), $gameState->getBoardState());
        $this->assertEquals($board->getLastMove()->getOppositeSign(), $gameState->getNextMove());
        $this->assertEquals($board->isGameOver(), $gameState->isOver());
        $this->assertEquals($board->getPlayerSign()->getValue(), $gameState->getPlayerSign());
        $this->assertEquals($board->getWinner(), $gameState->getWinner());
    }
}
