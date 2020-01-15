<?php

namespace ForumBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * CommentaireSu
 *
 * @ORM\Table(name="commentaire_su")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\CommentaireSuRepository")
 */

class CommentaireSu
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
     * @ORM\Column(name="CommentSu_content", type="string", length=255)
     * @Assert\NotBlank(message= " you must write a CommentContent")
     */
    private $commentSuContent;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="CommentSu_date", type="datetime")
     */
    private $commentSuDate;

    /**
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Sujet", inversedBy="commentss")
     * @ORM\JoinColumn(name="sujet_id",referencedColumnName="id")
     */
    private $post_id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\user", inversedBy="CommentaireSu")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }




    public function __construct()
    {
        $this->commentSuDate = new DateTime();
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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set commentSuContent
     *
     * @param string $commentSuContent
     *
     * @return CommentaireSu
     */
    public function setCommentSuContent($commentSuContent)
    {
        $this->commentSuContent = $commentSuContent;

        return $this;
    }

    /**
     * Get commentSuContent
     *
     * @return string
     */
    public function getCommentSuContent()
    {
        return $this->commentSuContent;
    }

    /**
     * Set commentSuDate
     *
     * @param DateTime $commentSuDate
     *
     * @return CommentaireSu
     */
    public function setCommentSuDate($commentSuDate)
    {
        $this->commentSuDate = $commentSuDate;

        return $this;
    }

    /**
     * Get commentSuDate
     *
     * @return DateTime
     */
    public function getCommentSuDate()
    {
        return $this->commentSuDate;
    }


}

