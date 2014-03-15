<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Form\DrivesType;
use Busko\EntityBundle\Entity\Drives;
use Symfony\Component\HttpFoundation\Request;
use Busko\JourneyBundle\Entity\Date1;
use Busko\JourneyBundle\Form\Date1Type;
use Symfony\Component\HttpFoundation\Response;
use Busko\EntityBundle\Form\DrivesUpdateType;
use Busko\EntityBundle\Entity\DrivesUpdate;

class HRAssignmentController extends Controller
{
    
    public function selectDateAction(){ 
        $form = $this->createForm(new Date1Type(), new Date1(),array(
            'action' => $this->generateUrl('busko_journey_HRAss'),
        ));
        return $this->render('BuskoJourneyBundle:Home:datedisplay.html.twig',array('form' => $form->createView()));
    }
    
    public function selectAction(Request $request)
    {
        $form1 = $this->createForm(new Date1Type(),  new Date1());
        $form1->handleRequest($request);
        if ($form1->isValid()) {
            $date = $form1->getData()->getDueDate();  
            $drives = new Drives();
            $form = $this->createForm(new DrivesType(), $drives,array(
                'action' => $this->generateUrl('create_drives_entry',array('date'=>$date->getTimeStamp())),
            ));
            return $this->render('BuskoJourneyBundle:HRAssignment:HRAss.html.twig',array('form' => $form->createView()));
        }
        return new Response("error");
    }
    
    public function updateAction(){
        $form = $this->createForm(new DrivesUpdateType(), new DrivesUpdate(),array(
            'action' => $this->generateUrl('update_drives_entry'),
        ));
        return $this->render('BuskoJourneyBundle:Home:datedisplay.html.twig',array('form' => $form->createView()));
    }
}

?>
