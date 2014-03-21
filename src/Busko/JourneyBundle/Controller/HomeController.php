<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Busko\JourneyBundle\Forms\TimetableType;


class HomeController extends Controller
{
    public function indexAction(Request $request)
    {
        $msgType = $request->get('type');
        $msgDetails = $request->get('message');
        echo $request->get('OK');
        $form = $this->createForm(new TimetableType(), null,array(
                'action' => $this->generateUrl('busko_journey_Timetablehomepage'),
                'attr'=>array(
                    'class' =>'form-horizontal', ))
                
                );
        return $this->render('BuskoJourneyBundle:Home:Home.html.twig', array('form' => $form->createView(),'type'=>$msgType,'message'=> $msgDetails));
    }
}
