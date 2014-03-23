<?php

namespace Busko\BranchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Branches;
use Busko\EntityBundle\Entity\Employees;
use Busko\EntityBundle\Form\BranchesType;
use Symfony\Component\HttpFoundation\Request;

/**/
class BranchPageController extends Controller
{
       public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Branches')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Branches entity.');
        }
        
       $editForm = $this->createEditForm($entity);
       
        return $this->render('BuskoBranchBundle:BranchPage:editBranch.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),
               
        ));
    }
       public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Branches')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Branches entity.');
        }

      
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        
       
        if ($editForm->isValid()) {
            try{
            $em->flush();
            }
            catch(\Exception $e){
                return $this->render('BuskoStyleBundle:Error:error.html.twig', array('message'=>'Branch Identifier cannot be changed!'));      
            }
        }
            return $this->redirect($this->generateUrl('confirm_branch'));
        

        return $this->render('BuskoBranchBundle:BranchPage:editBranch.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                   
        ));
    }
    private function createEditForm(Branches $entity) {
            $form = $this->createForm(new BranchesType(), $entity, array(
            'action' => $this->generateUrl('update_branch', array('id' => $entity->getBranchId())),
            'method' => 'POST',
            'attr' => array(
                'class'=>'form-horizontal center'
            )
            
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr'=> array( 'class'=>'btn btn-inverse')));
        return $form;
        
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
