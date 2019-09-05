<?php

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\BoardState;
use App\Domain\Exception\CellIsOccupied;
use App\Domain\Exception\IncorrectBoardState;
use App\Domain\Exception\IncorrectMoveSign;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class BoardStateTest extends TestCase
{
    public function testIncorrectBoardState(): void
    {
        $this->expectException(IncorrectBoardState::class);

        new BoardState([[new Sign(Sign::CROSS)]]);
    }

    public function testIncorrectMoveSign(): void
    {
        $this->expectException(IncorrectMoveSign::class);

        $boardState = new BoardState();
        $boardState->makeMove(
            new Move(Move::MIN_VALUE, Move::MIN_VALUE),
            new Sign(Sign::EMPTY)
        );
    }

    public function testCellIsOccupied(): void
    {
        $this->expectException(CellIsOccupied::class);

        $boardState = new BoardState();
        $boardState->makeMove(
            new Move(Move::MIN_VALUE, Move::MIN_VALUE),
            new Sign(Sign::ZERO)
        );
        $boardState->makeMove(
            new Move(Move::MIN_VALUE, Move::MIN_VALUE),
            new Sign(Sign::CROSS)
        );
    }
}
