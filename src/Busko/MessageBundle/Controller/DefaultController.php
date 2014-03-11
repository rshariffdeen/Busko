<?php

namespace Busko\MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BuskoMessageBundle:Default:index.html.twig', array('name' => $name));
    }
}
