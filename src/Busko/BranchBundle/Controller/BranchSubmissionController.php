<?php

namespace Busko\BranchBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Entity\Branches;
use Busko\EntityBundle\Form\BranchesType;

class BranchSubmissionController extends Controller
{
    public function submitBranchAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $id = $request->get('id');
        $form = $this->createForm(new BranchesType(), new Branches());

        $form->handleRequest($request);
        
        
        if ($form->isValid()) {
                $Branches = $form->getData();
                
                $em->persist($Branches);
                try{
                    $em->flush();
                }
                catch(\Exception $e){
                    return $this->render('BuskoBranchBundle:BranchSubmission:submitBranch.html.twig', array('id' => $id,'form' => $form->createView()));
                }

                return $this->redirect($this->generateUrl('confirm_branch',array('id'=>$id)));
        }

        return $this->render(
            'BuskoBranchBundle:Error:error.html.twig',
           array('form' => $form->createView(),'id'=>$id)
        );
    }

}


