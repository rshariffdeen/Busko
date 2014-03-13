<?php

namespace Busko\BusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Buses;
use Busko\EntityBundle\Entity\Employees;

class BusPageController extends Controller
{
    public function busPageAction()
    {
        $id = '10';
        $em = $this->getDoctrine()->getEntityManager();
        $employees = $em->getRepository('BuskoEntityBundle:Employees');
        $buses = $em->getRepository('BuskoEntityBundle:Buses');
        $employee = $employees->findOneBy(array('id' => $id));
        if($employee){          
            $bus = $buses->findAll();
            
            if(!in_array('ADMIN',$employee->getRoles())){
                    return $this->render('BuskoBusBundle:BusPage:busPage.html.twig', array('id' => $id,'bus'=> $bus));
            }
            if(in_array('ADMIN',$employee->getRoles())){
                    return $this->render('BuskoBusBundle:BusPage:busPageAdmin.html.twig', array('id' => $id,'bus'=> $bus));
            }
        }
        return $this->render('BuskoEmployeeBundle:Security:login.html.twig');
        
      
    }

}
