<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Assistants
 */
class Assistants
{
    /**
     * @var string
     */
    private $machineNumber;

    /**
     * @var \Busko\EntityBundle\Entity\Employees
     */
    private $id;


    /**
     * Set machineNumber
     *
     * @param string $machineNumber
     * @return Assistants
     */
    public function setMachineNumber($machineNumber)
    {
        $this->machineNumber = $machineNumber;

        return $this;
    }

    /**
     * Get machineNumber
     *
     * @return string 
     */
    public function getMachineNumber()
    {
        return $this->machineNumber;
    }

    /**
     * Set id
     *
     * @param \Busko\EntityBundle\Entity\Employees $id
     * @return Assistants
     */
    public function setId(\Busko\EntityBundle\Entity\Employees $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return \Busko\EntityBundle\Entity\Employees 
     */
    public function getId()
    {
        return $this->id;
    }
    
     public function setEmployees(\Busko\EntityBundle\Entity\Employees $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return \Busko\EntityBundle\Entity\Employees 
     */
    public function getEmployee()
    {
        return $this->id;
    }
}
