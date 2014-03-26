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
    
    
    
    
    public function routeAction(Request $request)
    {
        return $this->render('BuskoSiteBundle:Assistant:routes.html.twig',array('search'=>$request->get('search'),'search2'=>$request->get('search2')));
    }
    
    public function branchAction()
    {
        return $this->render('BuskoSiteBundle:Assistant:branches.html.twig');
    }
}
