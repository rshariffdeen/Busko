<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Journeys;
use Symfony\Component\HttpFoundation\Request;
use Busko\JourneyBundle\Entity\Date1;
use Busko\JourneyBundle\Form\Date1Type;
use Symfony\Component\HttpFoundation\Response;
use Busko\EntityBundle\Entity;
use Symfony\Component\Validator\Constraints\Range;
use \DateTime;

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
        ->add('roundNumber' , 'integer',array(
            'attr' => array(
                        'placeholder' => 'choose integer > 0'
                    ),
            'constraints' => array(
                new Range(
                        array('min' => 1))
                        )
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
        $date = $_POST['form']['date'];
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
        ->add('roundNumber' , 'integer',array(
            'attr' => array(
                        'placeholder' => 'choose integer > 0'
                    ),
            'constraints' => array(
                new Range(
                        array('min' => 1))
                        )
                    ))
        ->add('save', 'submit')
        ->add('date','hidden',array('data' => $date))
        ->setAction($this->generateUrl('busko_journey_setjourney'))
        ->setMethod('POST')
        ->getForm();
        
        $form->handleRequest($request);
     
        if ($form->isValid()) {
           $data = $form->getData();
           $starttime = $data->getStartTime();
           $roundnum = $data->getRoundNumber();
           $date = $data->getDate();
           $licnum = $data->getLicNum();
           
           $bus = $this->getDoctrine()
                            ->getRepository('BuskoEntityBundle:Buses')
                            ->findOneBy(array('licNum'=> $licnum));         
            
           $route = $bus->getRoute();
           $routeid = $bus->getRoute()->getRouteId();
                   
           if($roundnum%2==0){
               $startstop = $bus->getRoute()->getEndStop();
           }
           else{
               $startstop = $bus->getRoute()->getStartStop();
           }
                     
           $intermediates = $this->getDoctrine()->getRepository('BuskoEntityBundle:Intermediates')
                              ->findAll($routeid);
           
           $totduration = new DateTime('00:00:00');
                 
           
           echo "came here<br>";
           echo $totduration->getTimestamp();
           $journey = new Journeys();
           $journey->setDate($date);
           $journey->setLicNum($licnum);
           $journey->setStartTime($starttime);
           $journey->setRoundNumber($roundnum);
           $journey->setRoute($route);
           
           
           
           
        }else{
            return $this->render('BuskoJourneyBundle:TimeManage:busdisplay.html.twig',array('form' => $form->createView()));    
        }        
        
    }
}
?>
