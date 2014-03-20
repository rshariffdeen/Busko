<?php

namespace Busko\EntityBundle\Entity;

class DrivesUpdate
{

    protected $date;
    protected $licNum;
    
    public function setLicNum(\Busko\EntityBundle\Entity\Buses $licNum)
    {
        $this->licNum = $licNum;

        return $this;
    }
    
    public function getLicNum()
    {
        return $this->licNum;
    }
    public function getDate()
    {
        return $this->date;
    }

    public function setDate(\DateTime $date = null)
    {
        $this->date = $date;
    }
}
