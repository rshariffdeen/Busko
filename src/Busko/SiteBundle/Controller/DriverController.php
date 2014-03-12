<?php

namespace Busko\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DriverController extends Controller
{
     public function homeAction()
    {
        return $this->render('BuskoSiteBundle:Driver:home.html.twig');
    }
    
    public function employeeAction()
    {
        return $this->render('BuskoSiteBundle:Driver:employee.html.twig');
    }
    
  
    
    public function routesAction()
    {
        return $this->render('BuskoSiteBundle:Driver:routes.html.twig');
    }
    
    public function branchAction()
    {
        return $this->render('BuskoSiteBundle:Driver:branches.html.twig');
    }
}
