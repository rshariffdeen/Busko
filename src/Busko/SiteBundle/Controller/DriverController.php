<?php

namespace Busko\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DriverController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BuskoSiteBundle:Default:index.html.twig', array('name' => $name));
    }
}
