<?php

namespace Busko\BranchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Branches;
use Busko\EntityBundle\Entity\Employees;


/**/
class BranchPageController extends Controller
{
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Branches')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Branches entity.');
        }
        //creates form for editing
       $editForm = $this->createEditForm($entity);
       
        return $this->render('BuskoBusBundle:BranchPage:editBranch.html.twig', array(
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
            $em->flush();

            return $this->redirect($this->generateUrl('confirm_branch'));
        }

        return $this->render('BuskoBusBundle:Buses:form.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                   
        ));
    }
    private function createEditForm(Branches $entity) {
            $form = $this->createForm(new BranchesType(), $entity, array(
            'action' => $this->generateUrl('buses_update', array('id' => $entity->getBranchId())),
            'method' => 'PUT',
            'attr' => array(
                'class'=>'form-horizontal center'
            )
            
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr'=> array( 'class'=>'btn btn-inverse')));
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
