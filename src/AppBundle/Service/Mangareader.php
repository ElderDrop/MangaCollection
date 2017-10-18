<?php
/**
 * Created by PhpStorm.
 * User: jolszanski
 * Date: 18.09.17
 * Time: 20:49
 */

namespace AppBundle\Service;

use AppBundle\Entity\Genre;
use AppBundle\Entity\Manga as Manga;
use AppBundle\Entity\Status;
use AppBundle\Interfaces\IMangaCrawler;
use Doctrine\ORM\EntityManager;
use Goutte\Client;
use Symfony\Component\Console\Output\ConsoleOutput;
use \Symfony\Component\DomCrawler\Crawler;

class Mangareader implements IMangaCrawler
{

    private $em;
    private $crawler;
    private $urlString;
    private $url;
    private $genreService;

    /**
     * Mangareader constructor.
     * @param $url
     */
    public function __construct(string $url,EntityManager $em)
    {

        $this->em = $em;

        $this->urlString = $url;
        $this->url = parse_url($url);


        $client = new Client();
        $this->crawler = $client->request('GET',$url);
    }

    /**
     * @return Manga
     */
    public function getManga(): Manga
    {


        $manga = new Manga();
        $manga->setTitle($this->getTitle());
        $manga->setAuthor($this->getAuthor());
        $manga->addGenres($this->getGenres(new GenreService($this->em)));
        $manga->addStatus($this->getStatus());
        $manga->setUrl($this->urlString);
        return $manga;
    }


    /**
     * @return string
     */
    private function getTitle(): string
    {
        return $this->crawler->filter('.aname')->text();
    }

    /**
     * @return string
     */
    private function getAuthor(): string
    {
        $author = $this->crawler->filter('#mangaproperties table tr:nth-child(5) td')->last()->text();
        return ucwords(strtolower($author)); ;
    }

    private function getGenres(GenreService $gs): array
    {
        $this->genreService = $gs;

        $genres = $this->crawler->filter('#mangaproperties table tr:nth-child(8) a')->each(
            function (Crawler $node){
                $genre = $node->text();
                $genre = ucfirst(strtolower($genre));
                if($genre != "" && !$this->genreService->contains($genre)) {
                    $this->prepareGenreToSaveAndSaveIt($genre);
                }
                $genre = $this->em->getRepository('AppBundle:Genre')->findOneByName($genre);

                return $genre;
            });

        return $genres;

    }

    /**
     * @param string $genreName
     * @internal param string $genre
     */
    private function prepareGenreToSaveAndSaveIt(string $genreName): void
    {
        $genre = new Genre();
        $genre->setName($genreName);

        $genre->addLanguage($this->em->getRepository('AppBundle:Language')->findOneBy(array('languageShortName' => 'en')));

        $this->em->persist($genre);
        $this->em->flush();

    }

    public function getStatus():Status
    {
        $statusService = new StatusService($this->em);
        $status = $this->crawler->filter('#mangaproperties table tr:nth-child(4) td')->last()->text();
        if($existingStatus = $statusService->getStatusByStatusName($status))
        {
            return $existingStatus;
        }

        $newStatus = new Status();
        $newStatus->setStatus(ucfirst(strtolower($status)));

        $this->em->persist($newStatus);
        $this->em->flush();
        return $newStatus;
    }
}