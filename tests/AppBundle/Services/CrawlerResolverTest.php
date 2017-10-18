<?php
/**
 * Created by PhpStorm.
 * User: jolszanski
 * Date: 26.09.17
 * Time: 22:08
 */

namespace Tests\AppBundle\Services;


use AppBundle\Service\CrawlerResolver;
use AppBundle\Service\Mangareader;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Output\ConsoleOutput;

class CrawlerResolverTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

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
     * @dataProvider urlProvider
     * @param string $url
     */
    public function testGetIMangaCrawler(string $url)
    {
        $crawler = new CrawlerResolver($this->em);
        $error = null;
        try{
            $IMangaCrawler = $crawler->getIMangaCrawler($url);
            $manga = $IMangaCrawler->getManga();
            $this->assertNotNull($manga);
            $this->assertNotNull($manga->getAuthor());
            $this->assertnotNull($manga->getTitle());
            $this->assertNull($error);
        }
        catch ( \Exception $e){
            $error = $e->getMessage();
            $this->assertNotNull($error);
        }

    }

    public function urlProvider()
    {
        return array(
            array('http://waneko.pl/nasze-mangi/?manga_id=185'),
            array('http://waneko.pl/nasze-mangi/?manga_id=140'),
            array('http://waneko.pl/nasze-mangi/?manga_id=151'),
            array('http://www.mangareader.net/nanatsu-no-taizai/236'),
            array('www.onet.pl')

        );
    }
}