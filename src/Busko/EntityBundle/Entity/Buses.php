<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Buses
 */
class Buses
{
    /**
     * @var boolean
     */
    private $capacity;

    /**
     * @var string
     */
    private $model;

    /**
     * @var string
     */
    private $conditions;

    /**
     * @var string
     */
    private $licNum;

    /**
     * @var \Busko\EntityBundle\Entity\Branches
     */
    private $branch;

    /**
     * @var \Busko\EntityBundle\Entity\Routes
     */
    private $route;


    /**
     * Set capacity
     *
     * @param boolean $capacity
     * @return Buses
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return boolean 
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return Buses
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set conditions
     *
     * @param string $conditions
     * @return Buses
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return string 
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Get licNum
     *
     * @return string 
     */
    public function getLicNum()
    {
        return $this->licNum;
    }
        
     public function setLicNum($licnum)
    {
        return $this->licNum = $licnum;
    }
    /**
     * Set branch
     *
     * @param \Busko\EntityBundle\Entity\Branches $branch
     * @return Buses
     */
    public function setBranch(\Busko\EntityBundle\Entity\Branches $branch = null)
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get branch
     *
     * @return \Busko\EntityBundle\Entity\Branches 
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Set route
     *
     * @param \Busko\EntityBundle\Entity\Routes $route
     * @return Buses
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
