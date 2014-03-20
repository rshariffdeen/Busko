<?php

namespace Busko\BranchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BranchCreationControllerTest extends WebTestCase
{
    public function testCreatebranch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createBranch');
    }

}
