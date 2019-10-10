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

        $this->assertEquals(
            [
                'boardState' => $board->getBoardState()->getState(),
                'nextMove' => $board->getLastMove()->getOppositeSign(),
                'isOver' => $board->isGameOver(),
                'playerSign' => $board->getPlayerSign()->getValue(),
                'winner' => $board->getWinner(),
            ],
            $gameState);
    }
}
