<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Busko\JourneyBundle\Entity\Date1;
use Busko\JourneyBundle\Form\Date1Type;
use Busko\JourneyBundle\Entity\Journeys;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TimeManagementController extends Controller{
    
    public function selectDateAction(){
        $form = $this->createForm(new Date1Type(), new Date1(),array(
            'action' => $this->generateUrl('busko_journey_dep'),
        ));
        return $this->render('BuskoJourneyBundle:Home:datedisplay.html.twig',array('form' => $form->createView()));
    }
    
    public function  setDepartureTAction(Request $request){
        $date = $_POST['form']['dueDate'];
        $form = $this->createFormBuilder(new Journeys())
        ->add(
            'licNum',
            'entity',array(
                'label' => 'Bus ID',
                'class' => 'BuskoEntityBundle:Buses',
                'property' => 'lic_num',
                'query_builder' => function(EntityRepository $er) {
                                    return $er->createQueryBuilder('p')
                                              ->orderBy('p.licNum', 'ASC');
                                   }
            ))
        ->add('route','hidden',array('data' => $date))
        ->add('select', 'submit')
        ->setAction($this->generateUrl(''))
        ->setMethod('POST')
        ->getForm();
            
        return $this->render('BuskoJourneyBundle:Route:selectbus.html.twig',array('form' => $form->createView()));
    }
}

?>
