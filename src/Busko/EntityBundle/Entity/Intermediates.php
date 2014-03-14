<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="intermediates")
 */
class Intermediates
{
    /**
     * int
     */
    private $stationNumber;

    /**
     * @var string
     */
    private $stopId;

    /**
     * @var 
     */
    private $routeId;
    
     /**
     * time
     */
    
    private $duration;

    /**
     * Constructor
     */
    public function __construct()
    {
        
    }

    /**
     * Set station_number
     *
     * @param integer $station_number
     * 
     */
    public function setstationNumber($station_number)
    {
        $this->stationNumber = $station_number;

        return $this;
    }

    /**
     * Get station_number
     *
     * @return integer
     */
    public function getstationNumber()
    {
        return $this->stationNnumber;
    }

    /**
     * Get stopId
     *
     * @return string 
     */
    public function setStopId($stopId)
    {
        $this->stopId=$stopId;
    }
    public function getDuration()
    {
        return $this->duration;
    }
    public function setDuration($duration)
    {
        $this->duration=$duration;
    }
    public function getStopId()
    {
        return $this->stopId;
    }
    

    /**
     * Add route
     *
     * 
     * @return BusStops
     */
    public function addRoute( $route)
    {
        $this->routeId = $route;

        return $this;
    }

    /**
     * Remove route
     *
     * 
     */
    
    /**
     * Get route
     *
     * 
     */
    public function getRoute()
    {
        return $this->routeId;
    }
}
