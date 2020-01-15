<?php

namespace ForumBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;


/**
 * Sujet
 *
 * @ORM\Table(name="sujet")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\SujetRepository")
 */
class Sujet
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
     * @ORM\Column(name="Subject_name", type="string", length=255)
     * @Assert\NotBlank(message= " you must write a SubjectName")
     */
    private $subjectName;

    /**
     * @var string
     *
     * @ORM\Column(name="Subject_description", type="string", length=255)
     * @Assert\NotBlank(message= " you must write a Subject Description")
     */
    private $subjectDescription;

    /**
     * @ORM\OnetoMany(targetEntity="CommentaireSu",mappedBy="post_id")
     * @ORM\JoinColumn(name="commentss",referencedColumnName="id")
     */
    private $commentss;

    /**
     * Sujet constructor.
     * @param $commentss
     */
    public function __construct()
{
    $this->commentss = new ArrayCollection();
}

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getCommentss()
    {
        return $this->commentss;
    }

    /**
     * @param mixed $commentss
     */
    public function setCommentss($commentss)
    {
        $this->commentss = $commentss;
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
     * Set subjectName
     *
     * @param string $subjectName
     *
     * @return Sujet
     */
    public function setSubjectName($subjectName)
    {
        $this->subjectName = $subjectName;

        return $this;
    }

    /**
     * Get subjectName
     *
     * @return string
     */
    public function getSubjectName()
    {
        return $this->subjectName;
    }

    /**
     * Set subjectDescription
     *
     * @param string $subjectDescription
     *
     * @return Sujet
     */
    public function setSubjectDescription($subjectDescription)
    {
        $this->subjectDescription = $subjectDescription;

        return $this;
    }

    /**
     * Get subjectDescription
     *
     * @return string
     */
    public function getSubjectDescription()
    {
        return $this->subjectDescription;
    }


    /**
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\CategorieSu", inversedBy="Sujet")
     * @ORM\JoinColumn(name="CategorieSu_id", referencedColumnName="id")
     */
    private $categorieSu;


    /**
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\CommentaireSu", inversedBy="Sujet")
     * @ORM\JoinColumn(name="CommentaireSu_id", referencedColumnName="id")
     */
    private $commentairesu;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\user", inversedBy="Sujet")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getCommentairesu()
    {
        return $this->commentairesu;
    }

    /**
     * @param mixed $commentairesu
     */
    public function setCommentairesu($commentairesu)
    {
        $this->commentairesu = $commentairesu;
    }



    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Sujet
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getCategorieSu()
    {
        return $this->categorieSu;
    }

    /**
     * @param mixed $categorieSu
     */
    public function setCategorieSu($categorieSu)
    {
        $this->categorieSu = $categorieSu;
    }

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }



}

