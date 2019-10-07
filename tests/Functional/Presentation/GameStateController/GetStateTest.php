<?php

namespace App\Tests\Functional\Presentation\GameStateController;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetStateTest extends WebTestCase
{
    private const ENDPOINT = '/game';

    public function testGetState()
    {
        $client = self::createClient();
        $client->request(
            'GET',
            self::ENDPOINT
        );

        $this->assertEquals('{"error":"Game has not been started"}', $client->getResponse()->getContent());
    }
}
