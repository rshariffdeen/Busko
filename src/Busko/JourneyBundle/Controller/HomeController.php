<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\JourneyBundle\Forms\TimetableType;


class HomeController extends Controller
{
    public function indexAction()
    {
        $form = $this->createForm(new TimetableType(), array(
                'attr'=>array(
                    'class' =>'form-horizontal', ))
                );
        return $this->render('BuskoJourneyBundle:Home:Home.html.twig', array('form' => $form->createView()));
    }
}
