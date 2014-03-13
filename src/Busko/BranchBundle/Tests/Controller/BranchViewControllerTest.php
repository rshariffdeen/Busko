<?php

namespace Busko\BranchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BranchViewControllerTest extends WebTestCase
{
    public function testViewbranch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/viewBranch');
    }

}
