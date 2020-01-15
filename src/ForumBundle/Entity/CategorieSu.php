<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * CategorieSu
 *
 * @ORM\Table(name="categorie_su")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\CategorieSuRepository")
 */
class CategorieSu
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
     * @ORM\Column(name="Categorie_name", type="string", length=255)
     * @Assert\NotBlank(message= " you must write a CategorieName")
     */
    private $categorieName;


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
     * Set categorieName
     *
     * @param string $categorieName
     *
     * @return CategorieSu
     */
    public function setCategorieName($categorieName)
    {
        $this->categorieName = $categorieName;

        return $this;
    }

    /**
     * Get categorieName
     *
     * @return string
     */
    public function getCategorieName()
    {
        return $this->categorieName;
    }
    /**
     * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Sujet", mappedBy="CategorieSu")
     */
    private $sujet;

    /**
     * @return ArrayCollection
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * @param ArrayCollection $sujet
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
    }


    public function __construct()
    {
        $this->sujet = new ArrayCollection();
    }

    /**
     * @return Collection|Sujet[]
     */
    public function getProducts()
    {
        return $this->sujet;
    }


}

