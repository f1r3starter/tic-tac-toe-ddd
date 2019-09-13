<?php

namespace App\Tests\Unit\Domain\Strategy;

use App\Domain\Entity\Board;
use App\Domain\Strategy\MinMaxBotStrategy;
use App\Domain\ValueObject\Sign;
use PHPUnit\Framework\TestCase;

class MinMaxBotStrategyTest extends TestCase
{
    public function testMakeMove(): void
    {
        $board = new Board(
            new Sign(Sign::CROSS)
        );

        $botStrategy = new MinMaxBotStrategy();
        $botStrategySign = new Sign($board->getLastMove()->getOppositeSign());
        $opponentBotStrategy = new MinMaxBotStrategy();
        $opponentBotStrategySign = $board->getLastMove();

        while (!$board->isGameOver()) {
            $botStrategy->makeMove($board, $botStrategySign);
            $opponentBotStrategy->makeMove($board, $opponentBotStrategySign);
        }

        $this->assertEquals($board->getWinner(), $botStrategySign);
        $this->assertTrue($board->isGameOver());
    }
}
