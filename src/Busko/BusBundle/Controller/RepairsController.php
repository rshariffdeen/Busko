<?php

namespace Busko\BusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Busko\EntityBundle\Entity\Repairs;
use Busko\EntityBundle\Form\RepairsType;


class RepairsController extends Controller
{
    public function addRepairAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if ($user == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }
        $repair = new Repairs();
        $form = $this->createForm(new RepairsType(), $repair);
        $form->handleRequest($request);
        if ($form->isValid()) {
                $repair = $form->getData();
                $date=$repair->getStartDate()->getTimeStamp();
                $repair->setStartDate($date);
                $em->persist($repair);
                try{
                    $em->flush();
                }
                catch(\Exception $e){
                    return $this->render('BuskoStyleBundle:Error:error.html.twig', array('message'=>'Check whether the repair is valid!'));
                }
        }
          
         return $this->render('BuskoBusBundle:Repairs:addRepair.html.twig', array('form' => $form->createView())); 
        
        
       
       
    }


    public function showRepairsAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Buses')->find($id);
        $repairs=$em->getRepository('BuskoEntityBundle:Repairs')->findAll();

        if (!$entity) {
             return $this->render('BuskoStyleBundle:Error:error.html.twig', array(
                    'message' => ' bus could not be found'                   
                    
        ));}
        /*add query to retrieve repairs belonging to this bus*/
        $qb = $repairs->createQueryBuilder();
        /*send the selected repairs along with the template*/
        return $this->render('showRepairs.html.twig',array());
    }

}
