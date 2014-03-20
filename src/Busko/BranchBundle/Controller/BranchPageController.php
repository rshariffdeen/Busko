<?php

namespace Busko\BranchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Branches;
use Busko\EntityBundle\Entity\Employees;


/**/
class BranchPageController extends Controller
{
    public function branchPageAction()
    {
       $employee=$this->getUser();
        $em = $this->getDoctrine()->getEntityManager();
        $employees = $em->getRepository('BuskoEntityBundle:Employees');
        $branchRepo = $em->getRepository('BuskoEntityBundle:Branches');
        if($employee){          
            $branches = $branchRepo->findAll();
            //return $this->render('BuskoBranchBundle:BranchPage:branchPage.html.twig', array('id' => $id,'branch'=> $branch));
            if(!in_array('ADMIN',$employee->getRoles())){
                    return $this->render('BuskoBranchBundle:BranchPage:branchPage.html.twig', array('id' => $employee->getId(),'branches'=> $branches));
            }
            if(in_array('ADMIN',$employee->getRoles())){
                    return $this->render('BuskoBranchBundle:BranchPage:branchPageAdmin.html.twig', array('id'=>$employee->getId(),'branches'=> $branches));
            }
        }
        return $this->render('BuskoEmployeeBundle:Security:login.html.twig');
        
      
    }

}
