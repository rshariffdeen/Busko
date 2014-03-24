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
        $form = $this->createForm(new BranchesType(), new Branches(),array(
            'attr'=> array(
                'class' => 'form-horizontal center'
            )
        ));

        $form->handleRequest($request);
        
        
        if ($form->isValid()) {
                $Branch = $form->getData();
                $busstop=$Branch->getCity();
                $Branch->setCity($busstop->getCity());
                $em->persist($Branch);
                try{
                    $em->flush();
                }
                catch(\Exception $e){
                    return $this->render('BuskoBranchBundle:BranchSubmission:submitBranch.html.twig', array('id' => $id,'form' => $form->createView(),'type'=>'E','message'=>'ops! something is not right'));
                }

                return $this->redirect($this->generateUrl('branch_page',array('type'=>'S','message'=>'successfully added new branch')));
        }

        return $this->render(
            'BuskoStyleBundle:Error:error.html.twig',array('message'=>' could not add the branch') );
    }

}


