<?php

namespace Busko\BranchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Branches;
use Busko\EntityBundle\Entity\Employees;


/**/
class BranchPageController extends Controller
{
    public function editAction($id){
     
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Branches')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Branches entity.');
        }
        $form = $this->createForm(new BranchesType(), $Branch, array(
                'action' => $this->generateUrl('submit_branch'),
                'attr'  => array(
                    'class'=>'form-horizontal center'
                )
            ));
       
        return $this->render('BuskoBranchBundle:BranchCreation:createBranch.html.twig', array('form' => $form->createView()));
    }
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
