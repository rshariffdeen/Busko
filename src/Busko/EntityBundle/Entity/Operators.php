<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Operators
 */
class Operators
{
    /**
     * @var \Busko\EntityBundle\Entity\Employees
     */
    private $id;


    /**
     * Set id
     *
     * @param \Busko\EntityBundle\Entity\Employees $id
     * @return Operators
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
}
