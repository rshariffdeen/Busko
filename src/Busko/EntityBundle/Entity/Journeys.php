<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Journeys
 */
class Journeys
{
    /**
     * @var \DateTime
     */
    private $startTime;

    /**
     * @var \DateTime
     */
    private $endTime;

    /**
     * @var integer
     */
    private $roundNumber;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \Busko\EntityBundle\Entity\Buses
     */
    private $licNum;

    /**
     * @var \Busko\EntityBundle\Entity\BusStops
     */
    private $startStop;

    /**
     * @var \Busko\EntityBundle\Entity\Routes
     */
    private $route;


    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return Journeys
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return Journeys
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set roundNumber
     *
     * @param integer $roundNumber
     * @return Journeys
     */
    public function setRoundNumber($roundNumber)
    {
        $this->roundNumber = $roundNumber;

        return $this;
    }

    /**
     * Get roundNumber
     *
     * @return integer 
     */
    public function getRoundNumber()
    {
        return $this->roundNumber;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Journeys
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set licNum
     *
     * @param \Busko\EntityBundle\Entity\Buses $licNum
     * @return Journeys
     */
    public function setLicNum(\Busko\EntityBundle\Entity\Buses $licNum)
    {
        $this->licNum = $licNum;

        return $this;
    }

    /**
     * Get licNum
     *
     * @return \Busko\EntityBundle\Entity\Buses 
     */
    public function getLicNum()
    {
        return $this->licNum;
    }

    /**
     * Set startStop
     *
     * @param \Busko\EntityBundle\Entity\BusStops $startStop
     * @return Journeys
     */
    public function setStartStop(\Busko\EntityBundle\Entity\BusStops $startStop = null)
    {
        $this->startStop = $startStop;

        return $this;
    }

    /**
     * Get startStop
     *
     * @return \Busko\EntityBundle\Entity\BusStops 
     */
    public function getStartStop()
    {
        return $this->startStop;
    }

    /**
     * Set route
     *
     * @param \Busko\EntityBundle\Entity\Routes $route
     * @return Journeys
     */
    public function setRoute(\Busko\EntityBundle\Entity\Routes $route = null)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return \Busko\EntityBundle\Entity\Routes 
     */
    public function getRoute()
    {
        return $this->route;
    }
}
