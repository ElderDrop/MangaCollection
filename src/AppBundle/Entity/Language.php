<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 *
 * @ORM\Table(name="language")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LanguageRepository")
 */
class Language
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="languageName", type="string", length=255, unique=true)
     */
    private $languageName;

    /**
     * @var string
     *
     * @ORM\Column(name="languageShortName", type="string", length=5, unique=true)
     */
    private $languageShortName;

    /**
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="language")
     */
    private $genres;

    /**
     * Language constructor.
     */
    public function __construct()
    {
        $this->genres = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set languageName
     *
     * @param string $languageName
     *
     * @return Language
     */
    public function setLanguageName($languageName)
    {
        $this->languageName = $languageName;

        return $this;
    }

    /**
     * Get languageName
     *
     * @return string
     */
    public function getLanguageName()
    {
        return $this->languageName;
    }

    /**
     * Set languageShortName
     *
     * @param string $languageShortName
     *
     * @return Language
     */
    public function setLanguageShortName($languageShortName)
    {
        $this->languageShortName = $languageShortName;

        return $this;
    }

    /**
     * Get languageShortName
     *
     * @return string
     */
    public function getLanguageShortName()
    {
        return $this->languageShortName;
    }

    public function addGenre(Genre $genre)
    {
        $this->genres[] = $genre;
    }

    public function __toString(): string
    {
        return $this->getLanguageName();
    }
}

