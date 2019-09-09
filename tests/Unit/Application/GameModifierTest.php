<?php

namespace App\Tests\Unit\Application;

use App\Application\Exception\GameHasNotBeenStarted;
use App\Application\GameModifier;
use App\Application\GameStorage;
use App\Domain\Entity\Board;
use App\Domain\Strategy\BotStrategy;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class GameModifierTest extends TestCase
{
    public function testGetStateException(): void
    {
        $this->expectException(GameHasNotBeenStarted::class);

        $gameStorage = $this->getGameStorageMock();
        $gameStorage
            ->expects($this->once())
            ->method('gameStarted')
            ->willReturn(false);

        $botStrategy = $this->getBotStrategyMock();

        $gameModifier = new GameModifier($gameStorage, $botStrategy);
        $gameModifier->getState();
    }

    public function testGetStateSuccess(): void
    {
        $board = new Board(
            new Sign(Sign::CROSS)
        );

        $gameStorage = $this->getGameStorageMock();

        $gameStorage
            ->expects($this->once())
            ->method('gameStarted')
            ->willReturn(true);

        $gameStorage
            ->expects($this->once())
            ->method('restoreGameState')
            ->willReturn($board);

        $botStrategy = $this->getBotStrategyMock();

        $gameModifier = new GameModifier($gameStorage, $botStrategy);
        $returnedBoard = $gameModifier->getState();

        $this->assertEquals($board, $returnedBoard);
    }

    public function testMakeMoveThrowsException(): void
    {
        $this->expectException(GameHasNotBeenStarted::class);

        $gameStorage = $this->getGameStorageMock();
        $gameStorage
            ->expects($this->once())
            ->method('gameStarted')
            ->willReturn(false);

        $botStrategy = $this->getBotStrategyMock();

        $gameModifier = new GameModifier($gameStorage, $botStrategy);
        $gameModifier->makeMove(Move::MIN_VALUE, Move::MIN_VALUE);
    }

    public function testMakeMoveSuccess(): void
    {
        $playerSign = new Sign(Sign::CROSS);
        $botSign = new Sign($playerSign->getOppositeSign());

        $board = new Board(
            $playerSign
        );

        $botStrategy = $this->getBotStrategyMock();
        $expectedBoardState = [
            [new Sign(Sign::EMPTY), new Sign(Sign::EMPTY), new Sign(Sign::EMPTY)],
            [new Sign(Sign::EMPTY), new Sign(Sign::EMPTY), new Sign(Sign::CROSS)],
            [new Sign(Sign::ZERO), new Sign(Sign::EMPTY), new Sign(Sign::EMPTY)]
        ];

        if ($board->getLastMove()->equal($playerSign)) {
            $botStrategy
                ->expects($this->exactly(2))
                ->method('makeMove')
                ->will($this->onConsecutiveCalls(
                    $this->returnCallback(function () use ($board, $botSign) {
                        $board->makeMove(new Move(2, 2), $botSign);
                    }),
                    $this->returnCallback(function () use ($board, $botSign) {
                        $board->makeMove(new Move(2, 0), $botSign);
                    })
                ));

            $botStrategy->makeMove($board, $botSign);

            $expectedBoardState[2][2] = new Sign(Sign::ZERO);
        } else {
            $botStrategy
                ->expects($this->once())
                ->method('makeMove')
                ->will($this->returnCallback(function () use ($board, $botSign) {
                    $board->makeMove(new Move(2, 0), $botSign);
                }));
        }

        $gameStorage = $this->getGameStorageMock();

        $gameStorage
            ->expects($this->once())
            ->method('gameStarted')
            ->willReturn(true);

        $gameStorage
            ->expects($this->once())
            ->method('restoreGameState')
            ->willReturn($board);

        $gameModifier = new GameModifier($gameStorage, $botStrategy);

        $gameModifier->makeMove(1, 2);

        $this->assertEquals($board->getLastMove()->getValue(), $playerSign->getOppositeSign());
        $this->assertEquals(
            $expectedBoardState,
            $board->getBoardState()->getState()
        );
    }

    public function testChooseSign(): void
    {
        $playerSign = new Sign(Sign::CROSS);
        $botSign = new Sign($playerSign->getOppositeSign());

        $botStrategy = $this->getBotStrategyMock();
        $gameStorage = $this->getGameStorageMock();
        $gameStorage
            ->expects($this->once())
            ->method('restartGame');

        $board = new Board(
            $playerSign
        );

        if ($board->getLastMove()->equal($playerSign)) {
            $botStrategy
                ->method('makeMove')
                ->willReturnCallback(static function () use ($board, $botSign) {
                    $board->makeMove(new Move(2, 0), $botSign);
                });
        }

        $gameStorage
            ->expects($this->once())
            ->method('saveGameState');

        $gameModifier = new GameModifier($gameStorage, $botStrategy);
        $gameModifier->chooseSign($playerSign->getValue());
    }

    /**
     * @return MockObject|GameStorage
     */
    private function getGameStorageMock(): MockObject
    {
        return $this->createMock(GameStorage::class);
    }

    /**
     * @return MockObject|BotStrategy
     */
    private function getBotStrategyMock(): MockObject
    {
        return $this->createMock(BotStrategy::class);
    }
}
