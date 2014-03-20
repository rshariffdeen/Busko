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
        
        $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }

        if (in_array("ADMIN", $user->getRoles())) {
            $Branch = new Branches();
            $form = $this->createForm(new BranchesType(), $Branch, array(
                'action' => $this->generateUrl('submit_branch'),
                'attr'  => array(
                    'class'=>'form-horizontal center'
                )
            ));
            
          
           return $this->render('BuskoBranchBundle:BranchCreation:createBranch.html.twig', array('form' => $form->createView())); 
        
        }
        return $this->render('BuskoStyleBundle:Error:permission.html.twig');
       
    }

}
