<?php

namespace Busko\BusBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BusConfirmationControllerTest extends WebTestCase
{
    public function testConfirmbus()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/confirmBus');
    }

}
