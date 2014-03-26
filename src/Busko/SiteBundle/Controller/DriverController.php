<?php

namespace Busko\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \DateTime;
class DriverController extends Controller
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
                                  ->findBy(array('driv_id'=>$this->getUser()));
        
        for($i =0; $i <count($drives);$i++){
            $realdate = new DateTime();
            $realdate->setTimeStamp($drives[$i]->getDate());
            $stringdate = $realdate->format("Y M d");
            $drives[$i]->setDate($stringdate);
        }
        return $this->render('BuskoSiteBundle:Driver:home.html.twig', array(
                'type' => $request->get('type'),
                'message' => $request->get('message'),
                'journeys' => $journeys,
                'drives' => $drives,
                
        ));
    }
 
    
  
    
    public function routeAction()
    {
        return $this->render('BuskoSiteBundle:Driver:routes.html.twig');
    }
    
    public function branchAction()
    {
        return $this->render('BuskoSiteBundle:Driver:branches.html.twig');
    }
}
