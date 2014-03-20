<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Busko\EntityBundle\Entity\Routes;
use Busko\EntityBundle\Entity\Buses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TimeManagementController extends Controller{
    
    public function selectDateAction(Request $request){
        $form = $this->createForm(new Date1Type(), new Date1(),array(
            'action' => $this->generateUrl('busko_journey_HRAss'),
        ));
        return $this->render('BuskoJourneyBundle:Home:datedisplay.html.twig',array('form' => $form->createView()));
    }
    
    public function  setDepartureTAction(Request $request){
        
    }
}

?>
