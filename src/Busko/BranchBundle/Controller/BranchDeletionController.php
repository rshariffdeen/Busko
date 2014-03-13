<?php

namespace Busko\BranchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BranchDeletionController extends Controller
{
    public function deleteBranchAction(Request $request)
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

}
}