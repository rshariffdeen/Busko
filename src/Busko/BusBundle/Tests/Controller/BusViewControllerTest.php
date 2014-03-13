<?php

namespace Busko\BusBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BusViewControllerTest extends WebTestCase
{
    public function testViewbus()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/viewBus');
    }

}
