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
     * Checks if genre table contains this genre
     * @param string $genre
     * @return bool
     */
    public function contains(string $genre): bool
    {
        if ($this->allGenre == null ) $this->allGenre = $this->em->getRepository('AppBundle:Genre')->findAll();
        foreach ( $this->allGenre as $genreFromDatabase)
        {
            if (strtolower($genreFromDatabase->getName()) == $genre )return true;
        }
        return false;
    }
}