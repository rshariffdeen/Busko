<?php

namespace Busko\BusBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BusSubmissionControllerTest extends WebTestCase
{
    public function testSubmitbus()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/submitBus');
    }

}
