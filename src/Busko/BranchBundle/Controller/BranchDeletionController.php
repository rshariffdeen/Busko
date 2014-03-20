<?php

namespace Busko\BranchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Branches;
use Busko\BranchBundle\Form\BranchDeletionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BranchDeletionController extends Controller
{
    public function deleteBranchAction(Request $request)
    {
        $id = $request->get('id'); 
        $em = $this->getDoctrine()->getEntityManager();
        $employees = $em->getRepository('BuskoEntityBundle:Employees');
        $employee = $employees->findOneBy(array('id' => $id));
        if($employee){
            $defaultData = array('message' => 'Select Branch to delete');
            
            $form = $this->createFormBuilder($defaultData)
             ->add('branch', 'entity', array(
            'label' =>'Branch',
            'class' => 'BuskoEntityBundle:Branches',
            'property' => 'branchId',
            ))
            ->add('submit','submit', array(
                'label' => 'Delete Branch',
                'attr' => array(
                    'class' => 'button'
                )
            ))
           
            ->getForm();
            
            $form->handleRequest($request);

            if ($form->isValid()) {
                $message;
                $data = $form->getData();
                $branch=$data['branch'];
                $branchName= $branch->getBranchId();
                try{
                $em->remove($branch);
                $em->flush();
                $message='Branch '.$branchName.'has been deleted Successfully ';
                }
                catch(\Exception $e){
                    $message= 'Make sure that the branch you are trying to delete has no employees or buses associated with it!!';
                }
                
                return $this->render('BuskoBranchBundle:BranchDeletion:deleteBranchMessage.html.twig', array('message' => $message, 'id' => $id));
        
            }
            return $this->render('BuskoBranchBundle:BranchDeletion:deleteBranch.html.twig', array(
            'form' =>$form->createView(),
            ));

       
        }
        return $this->render('BuskoBranchBundle:BranchPage:branchPageAdmin.html.twig');
        }    
        

}