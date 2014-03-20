<?php

namespace Busko\BranchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BranchSubmissionControllerTest extends WebTestCase
{
    public function testSubmitbranch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/submitBranch');
    }

}
