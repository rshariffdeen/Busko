<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Drivers
 */
class Drivers
{
    /**
     * @var string
     */
    private $driverLicenceNumber;

    /**
     * @var \Busko\EntityBundle\Entity\Employees
     */
    private $id;


    /**
     * Set driverLicenceNumber
     *
     * @param string $driverLicenceNumber
     * @return Drivers
     */
    public function setDriverLicenceNumber($driverLicenceNumber)
    {
        $this->driverLicenceNumber = $driverLicenceNumber;

        return $this;
    }

    /**
     * Get driverLicenceNumber
     *
     * @return string 
     */
    public function getDriverLicenceNumber()
    {
        return $this->driverLicenceNumber;
    }

    /**
     * Set id
     *
     * @param \Busko\EntityBundle\Entity\Employees $id
     * @return Drivers
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
