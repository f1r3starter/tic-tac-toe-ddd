<?php

namespace App\Tests\Unit\Infrastructure;

use App\Domain\Entity\Board;
use App\Domain\ValueObject\Sign;
use App\Infrastructure\SessionStorage;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionStorageTest extends TestCase
{
    public function testRestoreGameTest(): void
    {
        $board = new Board(
            new Sign(Sign::CROSS)
        );

        $sessionMock = $this->getSessionMock();
        $sessionMock
            ->expects($this->once())
            ->method('get')
            ->willReturn(serialize($board))
        ;

        $sessionStorage = new SessionStorage($sessionMock);
        $restoredBoard = $sessionStorage->restoreGameState();

        $this->assertInstanceOf(Board::class, $restoredBoard);
    }

    public function testGameStarted(): void
    {
        $gameStarted = true;

        $sessionMock = $this->getSessionMock();
        $sessionMock
            ->expects($this->once())
            ->method('has')
            ->willReturn($gameStarted)
        ;

        $sessionStorage = new SessionStorage($sessionMock);

        $this->assertEquals(
            $gameStarted,
            $sessionStorage->gameStarted()
        );
    }

    public function testSaveGameState(): void
    {
        $board = new Board(
            new Sign(Sign::CROSS)
        );

        $sessionMock = $this->getSessionMock();
        $sessionMock
            ->expects($this->once())
            ->method('set')
            ->with('board', serialize($board))
        ;

        $sessionStorage = new SessionStorage($sessionMock);
        $sessionStorage->saveGameState($board);
    }

    public function testRestartGame(): void
    {
        $sessionMock = $this->getSessionMock();
        $sessionMock
            ->expects($this->once())
            ->method('remove')
            ->with('board')
        ;

        $sessionStorage = new SessionStorage($sessionMock);
        $sessionStorage->restartGame();
    }

    /**
     * @return MockObject|SessionInterface
     */
    private function getSessionMock(): MockObject
    {
        return $this->createMock(SessionInterface::class);
    }
}
