<?php

namespace Busko\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller {

    public function indexAction() {
        $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        if (in_array("ADMIN", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Admin:home');
        }
        
        if (in_array("OPERATOR", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Operator:home');
        }
        
         if (in_array("DRIVER", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Driver:home');
        }
        
        if (in_array("ASSISTANT", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Assistant:home');
        }
        
        
    }

    public function routeAction() {
        $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        if (in_array("ADMIN", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Admin:route');
        }
        
        if (in_array("OPERATOR", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Operator:route');
        }
        
        if (in_array("DRIVER", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Driver:route');
        }
        
        if (in_array("ASSISTANT", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Assistant:route');
        }
    }

    public function empAction(Request $request) {
        $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        if (in_array("ADMIN", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Admin:employee',array('request'=> $request));
        }
        
        if (in_array("OPERATOR", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Operator:employee',array('request'=> $request));
        }
        
      
    }

    public function branchAction() {
        $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        if (in_array("ADMIN", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Admin:branch');
        }
        
        if (in_array("OPERATOR", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Operator:branch');
        }
        
        if (in_array("DRIVER", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Driver:branch');
        }
        
        if (in_array("ASSISTANT", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Assistant:branch');
        }
    }

    public function busAction() {
        $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        if (in_array("ADMIN", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Admin:bus');
        }
        
        if (in_array("OPERATOR", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Operator:bus');
        }
        
        if (in_array("DRIVER", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Driver:bus');
        }
        
        if (in_array("ASSISTANT", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Assistant:bus');
        }
    }

}
