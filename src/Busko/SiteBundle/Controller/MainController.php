<?php

namespace Busko\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class MainController extends Controller {

    public function indexAction() {
        if ($this->getUser() == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }







        return $this->render('BuskoSiteBundle:Admin:home.html.twig');
    }

    public function routeAction() {
        if ($this->getUser() == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }
        return $this->render('BuskoSiteBundle:Admin:routes.html.twig');
    }

    public function empAction(Request $request) {
        if ($this->getUser() == null) {
            return $this->forward('FOSUserBundle:Security:login');
        } else {
            return $this->forward('BuskoSiteBundle:Admin:employee',array('request'=>$request));
            
           }
    }

    public function branchAction() {
        if ($this->getUser() == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }
        return $this->render('BuskoSiteBundle:Admin:branches.html.twig');
    }

    public function busAction() {
        if ($this->getUser() == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }
        return $this->render('BuskoSiteBundle:Admin:buses.html.twig');
    }

}
