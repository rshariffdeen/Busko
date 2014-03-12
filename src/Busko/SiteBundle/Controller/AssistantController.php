<?php

namespace Busko\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AssistantController extends Controller
{
     public function homeAction()
    {
        return $this->render('BuskoSiteBundle:Assistant:home.html.twig');
    }
    
    public function employeeAction()
    {
        return $this->render('BuskoSiteBundle:Assistant:employee.html.twig');
    }
    
    
    public function routesAction()
    {
        return $this->render('BuskoSiteBundle:Assistant:routes.html.twig');
    }
    
    public function branchAction()
    {
        return $this->render('BuskoSiteBundle:Assistant:branches.html.twig');
    }
}
