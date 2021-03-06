<?php

namespace App\Tests\Unit\Infrastructure;

use App\Domain\Entity\Board;
use App\Domain\ValueObject\Sign;
use App\Infrastructure\SessionStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\SerializerInterface;

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
            ->willReturn('123');

        $serializer = $this->getSerializerMock();
        $serializer
            ->expects($this->once())
            ->method('deserialize')
            ->with('123', Board::class, 'json')
            ->willReturn($board);

        $sessionStorage = new SessionStorage($sessionMock, $serializer);
        $restoredBoard = $sessionStorage->restoreGameState();

        $this->assertInstanceOf(Board::class, $restoredBoard);
    }

    /**
     * @return MockObject|SessionInterface
     */
    private function getSessionMock(): MockObject
    {
        return $this->createMock(SessionInterface::class);
    }

    /**
     * @return MockObject|SerializerInterface
     */
    private function getSerializerMock(): MockObject
    {
        return $this->createMock(SerializerInterface::class);
    }

    public function testGameStarted(): void
    {
        $gameStarted = true;

        $sessionMock = $this->getSessionMock();
        $sessionMock
            ->expects($this->once())
            ->method('has')
            ->willReturn($gameStarted);

        $serializer = $this->getSerializerMock();

        $sessionStorage = new SessionStorage($sessionMock, $serializer);

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
            ->with('board', '123');

        $serializer = $this->getSerializerMock();
        $serializer
            ->expects($this->once())
            ->method('serialize')
            ->with($board, 'json')
            ->willReturn('123');

        $sessionStorage = new SessionStorage($sessionMock, $serializer);
        $sessionStorage->saveGameState($board);
    }

    public function testRestartGame(): void
    {
        $sessionMock = $this->getSessionMock();
        $sessionMock
            ->expects($this->once())
            ->method('remove')
            ->with('board');

        $serializer = $this->getSerializerMock();

        $sessionStorage = new SessionStorage($sessionMock, $serializer);
        $sessionStorage->restartGame();
    }
}
