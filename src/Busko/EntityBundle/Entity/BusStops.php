<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BusStops
 */
class BusStops
{
    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $stopId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $route;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->route = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set city
     *
     * @param string $city
     * @return BusStops
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get stopId
     *
     * @return string 
     */
    public function getStopId()
    {
        return $this->stopId;
    }

    /**
     * Add route
     *
     * @param \Busko\EntityBundle\Entity\Routes $route
     * @return BusStops
     */
    public function addRoute(\Busko\EntityBundle\Entity\Routes $route)
    {
        $this->route[] = $route;

        return $this;
    }

    /**
     * Remove route
     *
     * @param \Busko\EntityBundle\Entity\Routes $route
     */
    public function removeRoute(\Busko\EntityBundle\Entity\Routes $route)
    {
        $this->route->removeElement($route);
    }

    /**
     * Get route
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoute()
    {
        return $this->route;
    }
}
