<?php

namespace Mahmoud\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reactionevent
 *
 * @ORM\Table(name="reactionevent")
 * @ORM\Entity(repositoryClass="Mahmoud\EventBundle\Repository\ReactioneventRepository")
 */
class Reactionevent
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
     * @return eventid
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @param eventid $eventId
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * @var eventid
     *@ORM\ManyToOne(targetEntity="Mahmoud\EventBundle\Entity\Event")
     */
    private $eventId;

    /**
     * @var userid
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $userId;

    /**
     * @return userid
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param userid $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="interest", type="integer", nullable=true)
     */
    private $interest;

    /**
     * @var int
     *
     * @ORM\Column(name="liked", type="integer", nullable=true)
     */
    private $liked;


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
     * Set interest
     *
     * @param integer $interest
     *
     * @return Reactionevent
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;

        return $this;
    }

    /**
     * Get interest
     *
     * @return int
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * Set liked
     *
     * @param integer $liked
     *
     * @return Reactionevent
     */
    public function setLiked($liked)
    {
        $this->liked = $liked;

        return $this;
    }

    /**
     * Get liked
     *
     * @return int
     */
    public function getLiked()
    {
        return $this->liked;
    }
}

