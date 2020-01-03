<?php

namespace Mahmoud\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="Mahmoud\EventBundle\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\Column(name="code", type="string" )
     */
    private $code;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }


    /**
     * @var userid
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $userId;

    /**
     * @var eventid
     *
     * @ORM\ManyToOne(targetEntity="Mahmoud\EventBundle\Entity\Event")
     */
    private $eventId;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

