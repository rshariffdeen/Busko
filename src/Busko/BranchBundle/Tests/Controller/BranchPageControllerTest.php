<?php

namespace Busko\BranchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BranchPageControllerTest extends WebTestCase
{
    public function testBranchpage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/branchPage');
    }

}
