<?php

namespace Busko\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function homeAction()
    {
        return $this->render('BuskoSiteBundle:Admin:home.html.twig');
    }
    
    public function employeeAction()
    {
        return $this->render('BuskoSiteBundle:Admin:employee.html.twig');
    }
    
    public function busAction()
    {
        return $this->render('BuskoSiteBundle:Admin:buses.html.twig');
    }
    
    public function routesAction()
    {
        return $this->render('BuskoSiteBundle:Admin:routes.html.twig');
    }
    
    public function branchAction()
    {
        return $this->render('BuskoSiteBundle:Admin:branches.html.twig');
    }
}
