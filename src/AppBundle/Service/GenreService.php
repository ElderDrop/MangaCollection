<?php
/**
 * Created by PhpStorm.
 * User: jolszanski
 * Date: 21.09.17
 * Time: 12:54
 */

namespace AppBundle\Service;


use AppBundle\Entity\Genre;
use Doctrine\ORM\EntityManager;

class GenreService
{
    private $em;
    private $allGenre;

    /**
     * GenreService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->allGenre = null;
    }

    /**
     * TODO:// usuń funkcje jeśli będzie nie przydatna
     * @param Genre $genre

    public function saveGenre(Genre $genre): void
    {
        if($genre != null)
        {
            $this->em->persist($genre);
        }
    }

    /**
     *
     */
    public function contains(string $genre): bool
    {
        if ($this->allGenre == null ) $this->allGenre = $this->em->getRepository('AppBundle:Genre')->findAll();
        foreach ( $this->allGenre as $genreFromDatabase)
        {
            if ($genreFromDatabase->getName() == $genre )return true;
        }
        return false;
    }
}