<?php

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\Board;
use App\Domain\Entity\BoardState;
use App\Domain\Exception\GameOver;
use App\Domain\Exception\SecondMove;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class BoardTest extends TestCase
{
    public function testSecondSameSignMove(): void
    {
        $this->expectException(SecondMove::class);
        $sign = new Sign(Sign::ZERO);

        $board = new Board($sign);
        $board->makeMove(new Move(Move::MIN_VALUE, Move::MAX_VALUE), $sign);
        $board->makeMove(new Move(Move::MAX_VALUE, Move::MIN_VALUE), $sign);
    }

    public function testGameOver(): void
    {
        $this->expectException(GameOver::class);
        $signZero = new Sign(Sign::ZERO);
        $signCross = new Sign(Sign::CROSS);
        $boardState = new BoardState([
            [$signZero, $signCross, $signZero],
            [$signZero, $signCross, $signZero],
            [$signZero, $signCross, $signZero],
        ]);

        $board = new Board($signZero, $boardState);
        $board->makeMove(
            new Move(Move::MAX_VALUE, Move::MIN_VALUE),
            new Sign($board->getLastMove()->getOppositeSign())
        );
    }

    public function testClone(): void
    {
        $sign = new Sign(Sign::ZERO);

        $board = new Board($sign);
        $newBoard = clone $board;

        $this->assertEquals($board, $newBoard);
        $this->assertEquals($board->getBoardState(), $newBoard->getBoardState());
    }

    public function testSerialization(): void
    {
        $sign = new Sign(Sign::ZERO);

        $board = new Board($sign);
        $serializedBoard = unserialize(serialize($board));

        $this->assertInstanceOf(Board::class, $serializedBoard);
    }
}
