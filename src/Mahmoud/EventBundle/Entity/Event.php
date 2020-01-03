<?php

namespace Mahmoud\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;


/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="Mahmoud\EventBundle\Repository\EventRepository")
 */

class Event
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
     * @Assert\NotBlank(message=" Please Add Event Title ")
     *
     * @ORM\Column(name="eventTitle", type="string", length=255)
     */
    private $eventTitle;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="eventPicture", type="blob" , nullable=true )
     *
     */
    private $eventPicture;

    private $rawPhoto;

    public function displayPhoto()
    {
        if(null === $this->rawPhoto) {
            $this->rawPhoto = "data:image/png;base64," . base64_encode(stream_get_contents($this->getEventPicture()));
        }

        return $this->rawPhoto;
    }


    /**
     * @var string
     *
     * @Assert\NotBlank(message=" Please Add Description For The Event  ")
     *
     * @ORM\Column(name="eventDescription", type="string", length=1024)
     */
    private $eventDescription;

    /**
     * @var integer
     *
     * @Assert\NotBlank(message=" Please Add Capacity Of The Event  ")
     *
     * @ORM\Column(name="eventNBRPlace", type="integer" )
     */
    private $eventNBRPlace;

    /**
     * @return integer
     *
     *
     */
    public function getEventNBRPlace()
    {
        return $this->eventNBRPlace;
    }

    /**
     * @param integer $eventNBRPlace
     */
    public function setEventNBRPlace($eventNBRPlace)
    {
        $this->eventNBRPlace = $eventNBRPlace;
    }


    /**
     * @var string
     *
     * @Assert\NotBlank(message=" Please Add Event Adress ")
     *
     * @ORM\Column(name="eventAdress", type="string", length=255)
     */
    private $eventAdress;

    /**
     * @var string
     *
     * @Assert\NotBlank(message=" Please Add Event Country ")
     *
     * @ORM\Column(name="eventCountry", type="string", length=128)
     */
    private $eventCountry;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern     =  "/(\d+\:\d+)/",message="Houre Should Be HH:MM like 12:30")
     *
     * @ORM\Column(name="eventHoure", type="string", length=10)
     */
    private $eventHoure;


    /**
     * @var \DateTime
     *
     * @Assert\Range(min="1-1-2020", max="+100 years")
     *
     *
     * @ORM\Column(name="eventStartDate", type="date")
     */
    private $eventStartDate;

    /**
     * @var \DateTime
     *
     * @Assert\Range(min="1-1-2020", max="+100 years")
     *
     * @Assert\Expression("this.getEventStartDate() < this.getEventEndDate()",
     *     message="End Date Should Be After Start Date")
     *
     * @ORM\Column(name="eventEndDate", type="date")
     */
    private $eventEndDate;

    /**
  * @var userid
   *
  * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
  */
    private $userId;


    /**
     * @var string
     *
     * @ORM\Column(name="eventCategory", type="string", length=255)
     */
    private $eventCategory;


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
     * Set eventTitle
     *
     * @param string $eventTitle
     *
     * @return event
     */
    public function setEventTitle($eventTitle)
    {
        $this->eventTitle = $eventTitle;

        return $this;
    }

    /**
     * Get eventTitle
     *
     * @return string
     */
    public function getEventTitle()
    {
        return $this->eventTitle;
    }

    /**
     * Set eventPicture
     *
     * @param string $eventPicture
     *
     * @return event
     */
    public function setEventPicture($eventPicture)
    {
        $this->eventPicture = $eventPicture;

        return $this;
    }

    /**
     * Get eventPicture
     *
     * @return string
     */
    public function getEventPicture()
    {
        return $this->eventPicture;
    }


    /**
     * Set eventDescription
     *
     * @param string $eventDescription
     *
     * @return event
     */
    public function setEventDescription($eventDescription)
    {
        $this->eventDescription = $eventDescription;

        return $this;
    }

    /**
     * Get eventDescription
     *
     * @return string
     */
    public function getEventDescription()
    {
        return $this->eventDescription;
    }

    /**
     * Set eventAdress
     *
     * @param string $eventAdress
     *
     * @return event
     */
    public function setEventAdress($eventAdress)
    {
        $this->eventAdress = $eventAdress;

        return $this;
    }

    /**
     * Get eventAdress
     *
     * @return string
     */
    public function getEventAdress()
    {
        return $this->eventAdress;
    }

    /**
     * Set eventCountry
     *
     * @param string $eventCountry
     *
     * @return event
     */
    public function setEventCountry($eventCountry)
    {
        $this->eventCountry = $eventCountry;

        return $this;
    }

    /**
     * Get eventCountry
     *
     * @return string
     */
    public function getEventCountry()
    {
        return $this->eventCountry;
    }

    /**
     * Set eventHoure
     *
     * @param string $eventHoure
     *
     * @return event
     */
    public function setEventHoure($eventHoure)
    {
        $this->eventHoure = $eventHoure;

        return $this;
    }

    /**
     * Get eventHoure
     *
     * @return string
     */
    public function getEventHoure()
    {
        return $this->eventHoure;
    }

    /**
     * Set eventStartDate
     *
     * @param \DateTime $eventStartDate
     *
     * @return event
     */
    public function setEventStartDate($eventStartDate)
    {
        $this->eventStartDate = $eventStartDate;

        return $this;
    }

    /**
     * Get eventStartDate
     *
     * @return \DateTime
     */
    public function getEventStartDate()
    {
        return $this->eventStartDate;
    }

    /**
     * Set eventEndDate
     *
     * @param \DateTime $eventEndDate
     *
     * @return event
     */
    public function setEventEndDate($eventEndDate)
    {
        $this->eventEndDate = $eventEndDate;

        return $this;
    }

    /**
     * Get eventEndDate
     *
     * @return \DateTime
     */
    public function getEventEndDate()
    {
        return $this->eventEndDate;
    }

    /**
     * Set eventCategory
     *
     * @param string $eventCategory
     *
     * @return event
     */
    public function setEventCategory($eventCategory)
    {
        $this->eventCategory = $eventCategory;

        return $this;
    }

    /**
     * Get eventCategory
     *
     * @return string
     */
    public function getEventCategory()
    {
        return $this->eventCategory;
    }

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


}

