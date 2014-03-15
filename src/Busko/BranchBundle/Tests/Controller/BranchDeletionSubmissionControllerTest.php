<?php

namespace Busko\BranchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BranchDeletionSubmissionControllerTest extends WebTestCase
{
    public function testSubmitbranchdeletion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/submitBranchDeletion');
    }

}
