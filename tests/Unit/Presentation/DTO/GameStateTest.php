<?php

namespace App\Tests\Unit\Presentation\DTO;

use App\Domain\Entity\Board;
use App\Domain\ValueObject\Sign;
use App\Presentation\DTO\GameState;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class GameStateTest extends TestCase
{
    public function testSerialize(): void
    {
        $board = new Board(
            new Sign(Sign::ZERO)
        );

        $gameState = new GameState($board);
        $serializedState = $gameState->jsonSerialize();

        $this->assertEquals(
            [
                'boardState' => $board->getBoardState()->getState(),
                'nextMove' => $board->getLastMove()->getOppositeSign(),
                'isOver' => $board->isGameOver(),
                'playerSign' => $board->getPlayerSign()->getValue(),
                'winner' => $board->getWinner(),
            ],
            $serializedState);
    }
}
