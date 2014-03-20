<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Routes
 */
class Routes
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var \Busko\EntityBundle\Entity\BusStops
     */
    private $startStop;

    /**
     * @var \Busko\EntityBundle\Entity\BusStops
     */
    private $endStop;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $stop;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stop = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get routeId
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id=$id;
    }

    /**
     * Set startStop
     *
     * @param \Busko\EntityBundle\Entity\BusStops $startStop
     * @return Routes
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
     * Set endStop
     *
     * @param \Busko\EntityBundle\Entity\BusStops $endStop
     * @return Routes
     */
    public function setEndStop(\Busko\EntityBundle\Entity\BusStops $endStop = null)
    {
        $this->endStop = $endStop;

        return $this;
    }

    /**
     * Get endStop
     *
     * @return \Busko\EntityBundle\Entity\BusStops 
     */
    public function getEndStop()
    {
        return $this->endStop;
    }

    /**
     * Add stop
     *
     * @param \Busko\EntityBundle\Entity\BusStops $stop
     * @return Routes
     */
    public function addStop(\Busko\EntityBundle\Entity\BusStops $stop)
    {
        $this->stop[] = $stop;

        return $this;
    }

    /**
     * Remove stop
     *
     * @param \Busko\EntityBundle\Entity\BusStops $stop
     */
    public function removeStop(\Busko\EntityBundle\Entity\BusStops $stop)
    {
        $this->stop->removeElement($stop);
    }

    /**
     * Get stop
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStop()
    {
        return $this->stop;
    }
    
    public function __toString(){
        return $this->routeId;
    }
}
