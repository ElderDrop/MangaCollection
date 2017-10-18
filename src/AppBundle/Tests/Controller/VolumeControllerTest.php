<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VolumeControllerTest extends WebTestCase
{
    public function testChangestate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/changeState');
    }

}
