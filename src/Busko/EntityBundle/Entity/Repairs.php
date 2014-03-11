<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Repairs
 */
class Repairs
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var string
     */
    private $repairState;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \Busko\EntityBundle\Entity\Buses
     */
    private $licNum;


    /**
     * Set description
     *
     * @param string $description
     * @return Repairs
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return Repairs
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set repairState
     *
     * @param string $repairState
     * @return Repairs
     */
    public function setRepairState($repairState)
    {
        $this->repairState = $repairState;

        return $this;
    }

    /**
     * Get repairState
     *
     * @return string 
     */
    public function getRepairState()
    {
        return $this->repairState;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Repairs
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set licNum
     *
     * @param \Busko\EntityBundle\Entity\Buses $licNum
     * @return Repairs
     */
    public function setLicNum(\Busko\EntityBundle\Entity\Buses $licNum)
    {
        $this->licNum = $licNum;

        return $this;
    }

    /**
     * Get licNum
     *
     * @return \Busko\EntityBundle\Entity\Buses 
     */
    public function getLicNum()
    {
        return $this->licNum;
    }
}
