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
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BuskoEntityBundle:Branches')->find($id);

            if (!$entity) {
                return $this->render('BuskoStyleBundle:Error:error.html.twig', array('message'=>'Unable to find Branch'));
            }
            try{
            $em->remove($entity);
            $em->flush();
            }
            catch (\Exception $e){
                return $this->render('BuskoStyleBundle:Error:error.html.twig', array('message'=>' Make sure the branch has no employee or buses attached to it'));
            
            }


            return $this->redirect($this->generateUrl('branch_page'));
                }    
        

}