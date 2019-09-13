<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\Exception\IncorrectSign;
use App\Domain\ValueObject\Sign;
use PHPUnit\Framework\TestCase;

class SignTest extends TestCase
{
    public function testEmptySign(): void
    {
        $sign = new Sign(Sign::EMPTY);

        $this->assertEquals($sign->getValue(), Sign::EMPTY);
        $this->assertEquals($sign->getOppositeSign(), Sign::EMPTY);
    }

    public function testOppositeSign(): void
    {
        $sign = new Sign(Sign::CROSS);

        $this->assertEquals($sign->getValue(), Sign::CROSS);
        $this->assertEquals($sign->getOppositeSign(), Sign::ZERO);

        $sign = new Sign(Sign::ZERO);

        $this->assertEquals($sign->getValue(), Sign::ZERO);
        $this->assertEquals($sign->getOppositeSign(), Sign::CROSS);
    }

    public function testIncorrectValue(): void
    {
        $this->expectException(IncorrectSign::class);
        new Sign('incorrect sign');
    }

    public function testEqual(): void
    {
        $sign = new Sign(Sign::CROSS);
        $signToEqual = new Sign(Sign::CROSS);
        $signNotToEqual = new Sign(Sign::ZERO);

        $this->assertTrue($sign->equal($signToEqual));
        $this->assertFalse($sign->equal($signNotToEqual));
    }

    public function testSerialize(): void
    {
        $sign = new Sign(Sign::CROSS);

        $this->assertEquals($sign->jsonSerialize(), Sign::CROSS);
    }
}
