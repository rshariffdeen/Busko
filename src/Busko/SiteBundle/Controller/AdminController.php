<?php

namespace Busko\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class AdminController extends Controller
{
    public function homeAction()
    {
        return $this->render('BuskoSiteBundle:Admin:home.html.twig');
    }
    
    public function employeeAction(Request $request)
    {
        $message= $request->get('message');      
            $type=$request->get('type');
         $em = $this->getDoctrine()->getManager();
         $repo = $em->getRepository('BuskoEntityBundle:Employees');
            //$employees = $em->getRepository('BuskoEntityBundle:Employees')->findAll();      
           // $admins = $em->getRepository('BuskoEntityBundle:Administrators')->findAll();
            //$operators = $em->getRepository('BuskoEntityBundle:Operators')->findAll();
           // $assistants = $em->getRepository('BuskoEntityBundle:Assistants')->findAll();
           // $drivers = $em->getRepository('BuskoEntityBundle:Drivers')->findAll();
            $Dquery = $em->createQuery('
        SELECT e
        FROM Busko\EntityBundle\Entity\Employees e
        WHERE e.id in (SELECT d FROM Busko\EntityBundle\Entity\Drivers d)');
           
        
        

            $drivers = $Dquery->getResult();
            
            $Aquery = $em->createQuery('
        SELECT e
        FROM Busko\EntityBundle\Entity\Employees e
        WHERE e.id in (SELECT a FROM Busko\EntityBundle\Entity\Administrators a)');
           
        
        

            $admins = $Aquery->getResult();

//            $Oquery = $em->createQuery('
//        SELECT e
//        FROM Busko\EntityBundle\Entity\Employees e
//        WHERE e.id in (SELECT o FROM Busko\EntityBundle\Entity\Operators o)');
           
        
        $Oquery = $repo->createQueryBuilder('a')
                ->where('a.roles LIKE :title')
                ->setParameter('title', '%OPERATOR%')
                ->getQuery();

            $operators = $Oquery->getResult();
            
            $ASquery = $em->createQuery('
        SELECT e
        FROM Busko\EntityBundle\Entity\Employees e
        WHERE e.id in (SELECT a FROM Busko\EntityBundle\Entity\Assistants a)');
           
        
        
           
            
            $assistants = $ASquery->getResult();
            
            return $this->render('BuskoSiteBundle:Admin:employees.html.twig', array('drivers' => $drivers, 'assistants' => $assistants, 'admins' => $admins, 'operators' => $operators,'message'=>$message,'type'=>$type));
        
    }
    
    public function busAction()
    {
        return $this->render('BuskoSiteBundle:Admin:buses.html.twig');
    }
    
    public function routeAction(Request $request)
    {
        return $this->render('BuskoSiteBundle:Admin:routes.html.twig',array('search'=>$request->get('search')));
    }
    
    public function branchAction()
    {
        return $this->render('BuskoSiteBundle:Admin:branches.html.twig');
    }
}
