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
        
        return $this->render('BuskoStyleBundle:Error:permission.html.twig');
        
    }

    public function routeAction(Request $request) {
        $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }
        
         $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('busstops_search'))
                ->setMethod('GET')
                ->add('city', 'entity', array(
            'label' =>'City',
            'label_attr' => array('class' => 'control-label'),
            'attr' => array(
            'class' =>'controls',
                'data-rel'=>'chosen'
                )
            ,
            'class' => 'BuskoEntityBundle:BusStops',
            'property' => 'city',
            ))
                ->add('search', 'submit', array('attr'=>array('class'=>'btn btn-primary')))
                ->getForm();

         $form2 = $this->createFormBuilder()
                ->setAction($this->generateUrl('routes_search'))
                ->setMethod('POST')
                ->add('routeId', 'entity', array(
            'label' =>'Route Id',
            'label_attr' => array('class' => 'control-label'),
            'attr' => array(
            'class' =>'controls',
                'data-rel'=>'chosen'
                )
            ,
            'class' => 'BuskoEntityBundle:Routes',
            'property' => 'routeId',
            ))
                ->add('search', 'submit', array('attr'=>array('class'=>'btn btn-primary')))
                ->getForm();
        

        if (in_array("ADMIN", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Admin:route',array('search'=>$form->createView(),'search2'=>$form2->createView(),'type'=>$request->get('type'),'message'=>$request->get('message')));
        }
        
        if (in_array("OPERATOR", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Operator:route',array('search'=>$form->createView(),'search2'=>$form2->createView()));
        }
        
        if (in_array("DRIVER", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Driver:route',array('search'=>$form->createView(),'search2'=>$form2->createView()));
        }
        
        if (in_array("ASSISTANT", $user->getRoles())) {
            return $this->forward('BuskoSiteBundle:Assistant:route',array('search'=>$form->createView(),'search2'=>$form2->createView()));
        }
        
        return $this->render('BuskoStyleBundle:Error:permission.html.twig');
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
        
        return $this->render('BuskoStyleBundle:Error:permission.html.twig');
      
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
        
      
        
        return $this->render('BuskoStyleBundle:Error:permission.html.twig');
    }

    

}
