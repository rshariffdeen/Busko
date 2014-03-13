<?php

namespace Busko\BusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Busko\EntityBundle\Entity\Buses;
use Busko\EntityBundle\Entity\Employees;

class BusViewController extends Controller
{
    public function viewBusAction(Request $request)
    {
        $id = $request->get('id');
        $busID=$request->get('bid');
        $em = $this->getDoctrine()->getEntityManager();
        $employees = $em->getRepository('BuskoEntityBundle:Employees');
        $buses = $em->getRepository('BuskoEntityBundle:Buses');
        $employee = $employees->findOneBy(array('id' => $id));
        if($employee){          
            $bus = $buses->findOneBy(array('licNum' => $busID));
            return $this->render('BuskoBusBundle:BusView:viewBus.html.twig', array('id' => $id,'bus'=> $bus));
        }
      
    
    }

}
