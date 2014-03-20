<?php

namespace Busko\JourneyBundle\Entity;

class Date1
{
    //duedate
    protected $dueDate;
  

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;
    }
}
