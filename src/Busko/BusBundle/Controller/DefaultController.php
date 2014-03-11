<?php

namespace Busko\BusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BuskoBusBundle:Default:index.html.twig', array('name' => $name));
    }
}
