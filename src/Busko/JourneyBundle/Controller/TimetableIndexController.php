<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Busko\JourneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Busko\JourneyBundle\Form\TimetableType;

class TimetableIndexController extends Controller {

    public function TimetableAction(Request $request) {
        
        $em = $this->getDoctrine()->getEntityManager();
        $form = $this->createForm(new TimetableType());

        $form->handleRequest($request);
        
        
        if ($form->isValid()) {
        
            $TimetableRequest = $form->getData();
        $Projectmanager=$Project->getProjectmanager();
        $projectmanagerid=$Projectmanager->getId();
        $Projectmanagername=$Projectmanager->getfirstname();
        $Projectname=$Project->getName();
        $Project->setProjectManager($projectmanagerid);
        $em->persist($Project);
        try{
            $em->flush();
        }
        catch(\Exception $e){
            return $this->render('VolunteerManagementSystemProjectBundle:projectsubmission:projectsubmission.html.twig', array('id' => $id,'form' => $form->createView()));
        }

        //return $this->redirect($this->generateUrl('projectconfirmation',array('id'=>$id,'pmid'=>$projectmanagerid,'pm'=>$Projectmanagername,'project'=>$Projectname)));
        }

    /*return $this->render(
        'VolunteerManagementSystemProjectBundle:Error:error.html.twig',
       array('form' => $form->createView(),'id'=>$id)
    );*/
       
    }

}



