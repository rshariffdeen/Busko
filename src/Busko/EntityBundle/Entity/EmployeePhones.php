<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmployeePhones
 */
class EmployeePhones
{
    /**
     * @var string
     */
    private $phone;

    /**
     * @var \Busko\EntityBundle\Entity\Employees
     */
    private $id;


    /**
     * Set phone
     *
     * @param string $phone
     * @return EmployeePhones
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set id
     *
     * @param \Busko\EntityBundle\Entity\Employees $id
     * @return EmployeePhones
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function __toString(){
        return $this->phone;
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
