<?php

namespace Busko\BranchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Busko\EntityBundle\Entity\Branches;
use Busko\EntityBundle\Entity\Employees;

class BranchViewController extends Controller
{
    public function viewBranchAction(Request $request)
    {
        $id = $request->get('id');
        $branchID=$request->get('bid');
        $em = $this->getDoctrine()->getEntityManager();
        $employees = $em->getRepository('BuskoEntityBundle:Employees');
        $branches = $em->getRepository('BuskoEntityBundle:Branches');
        $employee = $employees->findOneBy(array('id' => $id));
        if($employee){          
            $branch = $branches->findOneBy(array('branchId' => $branchID));
            return $this->render('BuskoBranchBundle:BranchView:viewBranch.html.twig', array('id' => $id,'branch'=> $branch));
        }
      
    }

}
