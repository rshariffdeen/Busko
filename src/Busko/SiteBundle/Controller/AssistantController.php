<?php

namespace Busko\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class AssistantController extends Controller
{
     public function homeAction()
    {
        return $this->render('BuskoSiteBundle:Assistant:home.html.twig');
    }
    
    
    
    
    public function routeAction()
    {
        return $this->render('BuskoSiteBundle:Assistant:routes.html.twig');
    }
    
    public function branchAction()
    {
        return $this->render('BuskoSiteBundle:Assistant:branches.html.twig');
    }
}
