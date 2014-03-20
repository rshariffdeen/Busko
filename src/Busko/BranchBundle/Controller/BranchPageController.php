<?php

namespace Busko\BranchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Branches;
use Busko\EntityBundle\Entity\Employees;



class BranchPageController extends Controller
{
    public function branchPageAction()
    {
        
        $id = '10';
        $em = $this->getDoctrine()->getEntityManager();
        $employees = $em->getRepository('BuskoEntityBundle:Employees');
        $branches = $em->getRepository('BuskoEntityBundle:Branches');
        $employee = $employees->findOneBy(array('id' => $id));
        if($employee){          
            $branch = $branches->findAll();
            //return $this->render('BuskoBranchBundle:BranchPage:branchPage.html.twig', array('id' => $id,'branch'=> $branch));
            if(!in_array('ADMIN',$employee->getRoles())){
                    return $this->render('BuskoBranchBundle:BranchPage:branchPage.html.twig', array('id' => $id,'branch'=> $branch));
            }
            if(in_array('ADMIN',$employee->getRoles())){
                    return $this->render('BuskoBranchBundle:BranchPage:branchPageAdmin.html.twig', array('id' => $id,'branch'=> $branch));
            }
        }
        return $this->render('BuskoEmployeeBundle:Security:login.html.twig');
        
      
    }

}
