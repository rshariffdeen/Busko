<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Busko\JourneyBundle\Forms\TimetableType;
use Busko\EntityBundle\Entity\Intermediates;



class InterController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $inter=new Intermediates();
        $inter->addRoute('120');
        $inter->setStopId('00001');
        $inter->setstationNumber(4);
        $inter->setDuration('08:30:00');
        echo ($inter->getDuration());
       $em->persist($inter);
       $em->flush();
        
        
         $form = $this->createForm(new TimetableType(), array(
                'attr'=>array(
                    'class' =>'form-horizontal', ))
                );
        return $this->render('BuskoJourneyBundle:Home:Home.html.twig', array('form' => $form->createView()));
        
    }
}
