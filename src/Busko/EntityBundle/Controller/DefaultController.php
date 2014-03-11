<?php

namespace Busko\EntityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BuskoEntityBundle:Default:index.html.twig', array('name' => $name));
    }
}
