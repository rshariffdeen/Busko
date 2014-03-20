<?php

namespace Busko\BranchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Branches;
use Busko\EntityBundle\Form\BranchesType;
use Symfony\Component\HttpFoundation\Request;


class BranchCreationController extends Controller
{
    public function createBranchAction(Request $request)
    {
       $id = $request->get('id'); 
        $em = $this->getDoctrine()->getEntityManager();
        $employees = $em->getRepository('BuskoEntityBundle:Employees');
        $employee = $employees->findOneBy(array('id' => $id));
        if($employee){
            $Branch = new Branches();
            $form = $this->createForm(new BranchesType(), $Branch, array(
                'action' => $this->generateUrl('submit_branch', array('id' => $id)),
            ));
            
          
           return $this->render('BuskoBranchBundle:BranchCreation:createBranch.html.twig', array('form' => $form->createView(), 'id' => $id)); 
        }   
        else {

            return $this->render('BuskoBranchBundle:BranchPage:branchPage.html.twig');
        }
    }

}
