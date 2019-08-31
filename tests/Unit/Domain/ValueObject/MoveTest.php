<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\Exception\MoveIsOutOfRange;
use App\Domain\ValueObject\Move;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class MoveTest extends TestCase
{
    public function testCorrectnessSetters(): void
    {
        $move = new Move(Move::MAX_VALUE, Move::MIN_VALUE);

        $this->assertEquals($move->getColumn(), Move::MIN_VALUE);
        $this->assertEquals($move->getRow(), Move::MAX_VALUE);
    }

    /**
     * @dataProvider rangeDataProvider
     *
     * @param int $row
     * @param int $column
     */
    public function testRowOutOfLowerRange(int $row, int $column): void
    {
        $this->expectException(MoveIsOutOfRange::class);
        new Move($row, $column);
    }

    public function testEquality(): void
    {
        $move = new Move(Move::MIN_VALUE, Move::MIN_VALUE);
        $moveToEqual = new Move(Move::MIN_VALUE, Move::MIN_VALUE);
        $moveNotToEqual = new Move(Move::MAX_VALUE, Move::MAX_VALUE);

        $this->assertTrue($move->equals($moveToEqual));
        $this->assertFalse($move->equals($moveNotToEqual));
    }

    /**
     * @return \Generator
     */
    public function rangeDataProvider(): \Generator
    {
        yield ['row' => Move::MIN_VALUE - 1, 'column' => Move::MIN_VALUE];
        yield ['row' => Move::MIN_VALUE, 'column' => Move::MIN_VALUE - 1];
        yield ['row' => Move::MAX_VALUE + 1, 'column' => Move::MAX_VALUE];
        yield ['row' => Move::MAX_VALUE, 'column' => Move::MAX_VALUE + 1];
    }
}
