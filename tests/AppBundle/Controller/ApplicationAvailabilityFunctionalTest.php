<?php
/**
 * Created by PhpStorm.
 * User: jolszanski
 * Date: 24.09.17
 * Time: 20:30
 */

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        return array(
            array('/'),
            array('/manga/'),
            array('/genre/')
        );
    }
}