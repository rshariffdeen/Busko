<?php

namespace Busko\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OperatorController extends Controller
{
      public function homeAction()
    {
        return $this->render('BuskoSiteBundle:Operator:home.html.twig');
    }
    
    public function employeeAction()
    {
        return $this->render('BuskoSiteBundle:Operator:employee.html.twig');
    }
    
    public function busAction()
    {
        return $this->render('BuskoSiteBundle:Operator:buses.html.twig');
    }
    
    public function routesAction()
    {
        return $this->render('BuskoSiteBundle:Operator:routes.html.twig');
    }
    
    public function branchAction()
    {
        return $this->render('BuskoSiteBundle:Operator:branches.html.twig');
    }
}
