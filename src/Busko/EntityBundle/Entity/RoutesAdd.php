<?php

namespace Busko\EntityBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoutesAdd
 */
class RoutesAdd
{
  
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $stop;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stop = new ArrayCollection();
    }

   

    /**
     * Add stop
     *
     * @param \Busko\EntityBundle\Entity\Intermediates $stop
     * @return Routes
     */
    public function addStop( $stop)
    {
        $this->stop[] = $stop;

        return $this;
    }

    /**
     * Remove stop
     *
     * @param \Busko\EntityBundle\Entity\Intermediates $stop
     */
    public function removeStop($stop)
    {
        $this->stop->removeElement($stop);
    }

    /**
     * Get stop
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStop()
    {
        return $this->stop;
    }
}
