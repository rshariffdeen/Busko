<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Branches
 */
class Branches
{
    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $streetno;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $branchId;


    /**
     * Set phone
     *
     * @param string $phone
     * @return Branches
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
     * Set streetno
     *
     * @param string $streetno
     * @return Branches
     */
    public function setStreetno($streetno)
    {
        $this->streetno = $streetno;

        return $this;
    }

    /**
     * Get streetno
     *
     * @return string 
     */
    public function getStreetno()
    {
        return $this->streetno;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Branches
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Branches
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
     * Get branchId
     *
     * @return string 
     */
    public function getBranchId()
    {
        return $this->branchId;
    }
     public function setBranchId($branchID)
    {
        $this->branchId=$branchID;
        return $this;
    }
    
    public function __toString(){
        return $this->branchId;
    }
}