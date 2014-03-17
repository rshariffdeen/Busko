<?php

namespace Busko\BranchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BranchConfirmationControllerTest extends WebTestCase
{
    public function testConfirmbranch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/confirmBranch');
    }

}
