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
        $form = $this->createForm(new RepairsType(), $repair,array(
            'attr' => array(
                'class' => 'form-horizontal center'
            )
        ));
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
                 return $this->forward('BuskoBusBundle:Buses:index',array('type'=>'S','message'=>'successfully added repair details to the bus')); 
        
        }
          
         return $this->render('BuskoBusBundle:Repairs:addRepair.html.twig', array('form' => $form->createView())); 
        
        
       
       
    }

       public function showRepairsAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BuskoEntityBundle:Buses')->find($id);
        

        if (!$entity) {
             return $this->render('BuskoStyleBundle:Error:error.html.twig', array(
                    'message' => ' bus could not be found'                   
                    
        ));}
        /*add query to retrieve repairs belonging to this bus*/
        $repository = $em->getRepository('BuskoEntityBundle:Repairs');
        $query = $repository->createQueryBuilder('r')
                    ->where('r.licNum = :title')
                    ->setParameter('title', $id)
                    ->getQuery();
        $repairs = $query->getResult();
        foreach($repairs as $r){
            $date=$r->getStartDate();
            /*Need to convert the string to date*/
            
            $r->setStartDate($date);
        
        }
        /*send the selected repairs along with the template*/
        return $this->render('BuskoBusBundle:Repairs:showRepairs.html.twig',array('repairs'=>$repairs,'id'=>$id));
    }
	
	

}
