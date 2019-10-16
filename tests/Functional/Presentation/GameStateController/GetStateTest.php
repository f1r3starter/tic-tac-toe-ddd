<?php

namespace App\Tests\Functional\Presentation\GameStateController;

use App\Domain\ValueObject\Sign;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetStateTest extends WebTestCase
{
    private const ENDPOINT = '/game';

    public function testGetEmptyState(): void
    {
        $client = self::createClient();
        $client->request(
            'GET',
            self::ENDPOINT
        );

        $this->assertEquals('{"error":"Game has not been started"}', $client->getResponse()->getContent());
    }

    public function testGetState(): void
    {
        $client = self::createClient();
        $client->request(
            'POST',
            self::ENDPOINT,
            [],
            [],
            [],
            json_encode(['sign' => Sign::CROSS])
        );
        $client->request(
            'GET',
            self::ENDPOINT
        );

        $this->assertEquals('', $client->getResponse());
    }
}
