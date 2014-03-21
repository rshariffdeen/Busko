<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Form\DrivesType;
use Busko\EntityBundle\Entity\Journeys;
use Symfony\Component\HttpFoundation\Request;
use Busko\JourneyBundle\Entity\Date1;
use Busko\JourneyBundle\Form\Date1Type;
use Symfony\Component\HttpFoundation\Response;
use Busko\EntityBundle\Form\DrivesUpdateType;
use Busko\EntityBundle\Entity\DrivesUpdate;

class TimeManagementController extends Controller
{
    
    public function selectDateAction(){ 
        $form = $this->createForm(new Date1Type(), new Date1(),array(
            'action' => $this->generateUrl('busko_journey_selectdepbus'),
        ));
        return $this->render('BuskoJourneyBundle:TimeManage:datedisplay.html.twig',array('form' => $form->createView()));
    }
    
    public function selectDepaAction(Request $request){
        $form1 = $this->createForm(new Date1Type(),  new Date1());
        $form1->handleRequest($request);
     
        if ($form1->isValid()) {
            $date = $form1->getData()->getDueDate()->getTimeStamp();  
            $form = $this->createFormBuilder(new Journeys())
        ->add(
            'licNum',
            'entity',array(
                'label' => 'Bus License Number',
                'class' => 'BuskoEntityBundle:Buses',
                'property' => 'lic_num',
            ))
        ->add('startTime','time',array(
            'label' => 'Departure Time',
        ))
        ->add('save', 'submit')
        ->add('date','hidden',array('data' => $date))
        ->setAction($this->generateUrl('busko_journey_setjourney'))
        ->setMethod('POST')
        ->getForm();
            
        return $this->render('BuskoJourneyBundle:TimeManage:busdisplay.html.twig',array('form' => $form->createView()));    
        }
        
        new Response("error");
    }
    
    
    public function setJourneyAction(Request $request){
        echo $_POST['form']['licNum']." ";
        echo $_POST['form']['date']." ";
        echo $_POST['form']['startTime']['hour']." ";
        echo $_POST['form']['startTime']['minute']." ";
        
        
    }
}
?>
