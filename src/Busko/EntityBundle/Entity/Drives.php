<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Drives
 */
class Drives
{
    /**
     * @var string
         */
    private $date;

    /**
     * @var \Busko\EntityBundle\Entity\Buses
     */
    private $licNum;

    /**
     * @var \Busko\EntityBundle\Entity\Assistants
     */
    private $ass;

    /**
     * @var \Busko\EntityBundle\Entity\Drivers
     */
    private $driv;


   /**
     * @var string
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @var string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set licNum
     *
     * @param \Busko\EntityBundle\Entity\Buses $licNum
     * @return Drives
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

    /**
     * Set ass
     *
     * @param \Busko\EntityBundle\Entity\Assistants $ass
     * @return Drives
     */
    public function setAss(\Busko\EntityBundle\Entity\Assistants $ass = null)
    {
        $this->ass = $ass;

        return $this;
    }

    /**
     * Get ass
     *
     * @return \Busko\EntityBundle\Entity\Assistants 
     */
    public function getAss()
    {
        return $this->ass;
    }

    /**
     * Set driv
     *
     * @param \Busko\EntityBundle\Entity\Drivers $driv
     * @return Drives
     */
    public function setDriv(\Busko\EntityBundle\Entity\Drivers $driv = null)
    {
        $this->driv = $driv;

        return $this;
    }

    /**
     * Get driv
     *
     * @return \Busko\EntityBundle\Entity\Drivers 
     */
    public function getDriv()
    {
        return $this->driv;
    }
    public function  getDrives(){
        return $this;
    }
}
