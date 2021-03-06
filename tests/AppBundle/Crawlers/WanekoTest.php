<?php
/**
 * Created by PhpStorm.
 * User: elderdrop
 * Date: 18.10.17
 * Time: 12:32
 */

namespace Tests\AppBundle\Crawlers;


use AppBundle\Crawlers\Waneko;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WanekoTest extends WebTestCase
{
    public $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
    /**
     * @dataProvider urlsProvider
     * @param string $url
     */
    public function testGetManga(string $url)
    {
        $waneko = new Waneko($url,$this->em);

        $this->assertNotNull($waneko->getManga());
    }

    /**
     * @dataProvider urlsProvider
     * @param string $url
     * @param string $wantedTitle
     */
    public function testTitle(string $url,string $wantedTitle)
    {
        $waneko = new Waneko($url,$this->em);
        $wantedTitle = ucfirst(strtolower($wantedTitle));

        $this->assertEquals($wantedTitle, $waneko->getManga()->getTitle());
    }

    /**
     * Providers
     */
    public function urlsProvider()
    {
        return array(
            array('http://waneko.pl/nasze-mangi/?manga_id=146',"ACONY"),
            array('http://waneko.pl/nasze-mangi/?manga_id=94',"ORANGE"),
        );
    }


}