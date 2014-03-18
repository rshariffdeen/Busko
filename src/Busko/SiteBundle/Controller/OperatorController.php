<?php

namespace Busko\SiteBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OperatorController extends Controller
{
      public function homeAction()
    {
        return $this->render('BuskoSiteBundle:Operator:home.html.twig');
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
            
            return $this->render('BuskoSiteBundle:Operator:employees.html.twig', array('drivers' => $drivers, 'assistants' => $assistants, 'admins' => $admins, 'OP'=>'false','operators' => $operators,'message'=>$message,'type'=>$type));
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
