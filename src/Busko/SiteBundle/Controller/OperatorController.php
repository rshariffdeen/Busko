<?php

namespace Busko\SiteBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \DateTime;
class OperatorController extends Controller
{
    public function homeAction(Request $request)
    {
        $today = new \DateTime;
        $date = $today->getTimestamp();
        $date /= 100000;
        $date = (int)$date;
        $date = $date."%";
        
        $journeys = $this->getDoctrine()->getEntityManager()
                                  ->getRepository('BuskoEntityBundle:Journeys')
                                  ->createQueryBuilder('o')
                                  ->where ('o.date LIKE :date')
                                  ->orderBy('o.startTime')
                                  ->setParameter('date', $date)
                                  ->getQuery()
                                  ->getResult();
        
        for($i =0; $i <count($journeys);$i++){
            $realdate = new DateTime();
            $realdate->setTimeStamp($journeys[$i]->getDate());
            $stringdate = $realdate->format("Y M d");
            $journeys[$i]->setDate($stringdate);
        }
      
        $drives = $this->getDoctrine()->getEntityManager()
                                  ->getRepository('BuskoEntityBundle:Drives')
                                  ->createQueryBuilder('o')
                                  ->where ('o.date LIKE :date')
                                  ->setParameter('date', $date)
                                  ->getQuery()
                                  ->getResult();
        
        for($i =0; $i <count($drives);$i++){
            $realdate = new DateTime();
            $realdate->setTimeStamp($drives[$i]->getDate());
            $stringdate = $realdate->format("Y M d");
            $drives[$i]->setDate($stringdate);
        }
        return $this->render('BuskoSiteBundle:Operator:home.html.twig', array(
                'type' => $request->get('type'),
                'message' => $request->get('message'),
                'journeys' => $journeys,
                'drives' => $drives,
                
        ));
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
    
    
    
    public function routeAction(Request $request)
    {
        return $this->render('BuskoSiteBundle:Operator:routes.html.twig',array('search'=>$request->get('search'),'search2'=>$request->get('search2')));
    }
    
    public function branchAction()
    {
        return $this->render('BuskoSiteBundle:Operator:branches.html.twig');
    }
}
