<?php

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\WinnerState;
use App\Domain\Exception\IncorrectMoveSign;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Sign;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class WinnerStateTest extends TestCase
{
    public function testIncorrectSign(): void
    {
        $this->expectException(IncorrectMoveSign::class);

        $winnerState = new WinnerState();
        $winnerState->makeMove(
            new Move(Move::MIN_VALUE, Move::MIN_VALUE),
            new Sign(Sign::EMPTY)
        );
    }
}
