<?php

namespace Busko\BusBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BusCreationControllerTest extends WebTestCase
{
    public function testCreatebus()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createBus');
    }

}
