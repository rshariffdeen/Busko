<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Form\DrivesType;
use Busko\EntityBundle\Entity\Drives;
use Symfony\Component\HttpFoundation\Request;
use Busko\EntityBundle\Form\DrivesUpdateType;
use Busko\EntityBundle\Entity\DrivesUpdate;
use Doctrine\ORM\EntityRepository;

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
    
    public function updateAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();
        $form = $this->createForm(new DrivesUpdateType(),  new DrivesUpdate());
        $form->handleRequest($request);
        if ($form->isValid()) {
            $drives = $form->getData();
            
            $product = $this->getDoctrine()
                            ->getRepository('BuskoEntityBundle:Drives')
                            ->findOneBy(array('date'=> $drives->getDate()->getTimeStamp(),'licNum' => $drives->getLicNum()));
            
            if($product){
                $drivid = $product->getAss()->getId();
                $assid = $product->getDriv()->getId();
                
                return $this->render('BuskoJourneyBundle:HRAssignment:update.html.twig',array('driv' => $drivid,'ass' => $assid));
            }
            else{
                echo "There is no such entry, first set the bus to the particular date";
            }
        }
        
        return new Response("works");
    }
    
    public function updateDriverAction(){
        $form = $this->createFormBuilder(new Drives())
        ->add(
            'driv',
            'entity',array(
                'label' => 'Driver',
                'class' => 'BuskoEntityBundle:Drivers',
                'property' => 'id',
                'query_builder' => function(EntityRepository $er) {
                                    return $er->createQueryBuilder('p')
                                              ->orderBy('p.id', 'ASC');
                                   }
            )    )
        ->add('save', 'submit')
        ->getForm();
        return $this->render('BuskoJourneyBundle:HRAssignment:selectdriver.html.twig',array('form' => $form->createView()));
    }

    public function resetDriverAction(Request $request){
        echo $request->getContent();
    }
    
}
?>
