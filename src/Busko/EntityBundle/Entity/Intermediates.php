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
    private $id;

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
    public function getStationNumber()
    {
        return $this->stationNumber;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function setId($id)
    {
        $this->id=$id;
    }
    public function getDuration()
    {
        return $this->duration;
    }
    public function setDuration($duration)
    {
        $this->duration=$duration;
    }
    public function getId()
    {
        return $this->id;
    }
    

    /**
     * Add route
     *
     * 
     * @return BusStops
     */
    public function setRouteId( $route)
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
    public function getRouteId()
    {
        return $this->routeId;
    }
}
