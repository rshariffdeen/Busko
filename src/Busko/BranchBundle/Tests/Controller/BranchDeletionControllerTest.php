<?php

namespace Busko\BranchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BranchDeletionControllerTest extends WebTestCase
{
    public function testDeletebranch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteBranch');
    }

}
