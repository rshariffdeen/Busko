<?php

namespace Busko\BusBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RepairsControllerTest extends WebTestCase
{
    public function testAddrepair()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addRepair');
    }

    public function testShowrepairs()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showRepairs');
    }

}
