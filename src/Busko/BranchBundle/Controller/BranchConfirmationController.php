<?php

namespace Busko\BranchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BranchConfirmationController extends Controller
{
    public function confirmBranchAction(Request $request)
    {
        $id = $request ->get('id');
        return $this->render('BuskoBranchBundle:BranchConfirmation:confirmBranch.html.twig',array('id'=>$id));
    }

}


