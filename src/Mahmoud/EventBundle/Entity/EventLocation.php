<?php

namespace Mahmoud\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventLocation
 *
 * @ORM\Table(name="event_location")
 * @ORM\Entity(repositoryClass="Mahmoud\EventBundle\Repository\EventLocationRepository")
 */


class EventLocation
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
     * @var eventid
     *@ORM\OneToOne(targetEntity="Mahmoud\EventBundle\Entity\Event")
     */
    private $eventId;

    /**
     * @var float
     *
     * @ORM\Column(name="lattitude", type="float")
     */
    private $lattitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;


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
     * Set lattitude
     *
     * @param float $lattitude
     *
     * @return EventLocation
     */
    public function setLattitude($lattitude)
    {
        $this->lattitude = $lattitude;

        return $this;
    }

    /**
     * Get lattitude
     *
     * @return float
     */
    public function getLattitude()
    {
        return $this->lattitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return EventLocation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
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

}

