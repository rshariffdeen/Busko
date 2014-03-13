<?php

namespace Busko\BusBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BusPageControllerTest extends WebTestCase
{
    public function testBuspage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/busPage');
    }

}
