<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Form\DrivesType;
use Busko\EntityBundle\Entity\Drives;
use Symfony\Component\HttpFoundation\Request;

class DrivesController extends Controller
{
    public function setAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $form = $this->createForm(new DrivesType(),  new Drives());
        $form->handleRequest($request);
        if ($form->isValid()) {
            $date = $request->get('date');
            $drives = $form->getData();
            $drives->setDate($date);
            
            $product = $this->getDoctrine()
                            ->getRepository('BuskoEntityBundle:Drives')
                            ->findOneBy(array('date'=> $date,'licNum' => $drives->getLicNum()));
            
            if (!$product) {
                try {
                $em->persist($drives);
                $em->flush();
                } catch (Exception $e) {}
            }
            else{
                echo "The bus has already been assigned for the day, select a different bus";
            }
        }
        
        $date = $request->get('date');  
        $drives = new Drives();
        $form1 = $this->createForm(new DrivesType(), $drives,array(
                'action' => $this->generateUrl('create_drives_entry',array('date'=>$date)),
        ));
        return $this->render('BuskoJourneyBundle:HRAssignment:HRAss.html.twig',array('form' => $form1->createView()));
    }
}
?>
