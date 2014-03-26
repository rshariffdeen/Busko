<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Busko\EntityBundle\Form\DrivesType;
use Busko\EntityBundle\Entity\Drives;
use Busko\EntityBundle\Entity\Employees;
use Symfony\Component\HttpFoundation\Request;
use Busko\EntityBundle\Form\DrivesUpdateType;
use Busko\EntityBundle\Entity\DrivesUpdate;
use Doctrine\ORM\EntityRepository;
use \DateTime;

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
                } catch (\Exception $e) {
                  return $this->render('BuskoJourneyBundle:HRAssignment:HRAss.html.twig',array('type'=>'E','message'=>'Oops! There was something wrong!', 'form' => $form->createView()));
     
              
                }
                return $this->render('BuskoJourneyBundle:HRAssignment:HRAss.html.twig',array('type'=>'S','message'=>'successfully assigned driver and assistant', 'form' => $form->createView()));
     
            }
            
                 
            
            return $this->render('BuskoJourneyBundle:HRAssignment:HRAss.html.twig',array('type'=>'E','message'=>'The bus has already been assigned for the day, select a different bus', 'form' => $form->createView()));
     
            
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
                $assid = $product->getAss()->getId();
                $drivid = $product->getDriv()->getId();
                $date = $drives->getDate()->getTimestamp();
                $lic = $drives->getLicNum()->getLicNum();
                return $this->render('BuskoJourneyBundle:HRAssignment:update.html.twig',array('driv' => $drivid,'ass' => $assid, 'date' =>$date, 'lic' => $lic));
            }
            else{
               return $this->render('BuskoJourneyBundle:Home:showdate.html.twig',array('form' => $form->createView(),'type'=>'E','message'=>'there is no journey set to this bus on the specified date'));
    
            }
        }
        
        return new Response("works");
    }
    
    public function updateDriverAction(Request $request){
        $date = $request->get('date');
        $lic = $request->get('lic');
        
        $form = $this->createFormBuilder(new Drives())
        ->add(
            'driv',
            'entity',array(
                'label' => 'Driver',
                'class' => 'BuskoEntityBundle:Drivers',
                'property' => 'id',
            ))
        ->add('date','hidden',array('data' => $date))
        ->add('licNum','hidden',array('data' => $lic))
        ->add('save', 'submit')
        ->setAction($this->generateUrl('reset_drives_driver'))
        ->setMethod('POST')
        ->getForm();
        return $this->render('BuskoJourneyBundle:HRAssignment:selectdriver.html.twig',array('form' => $form->createView()));
    }

    public function resetDriverAction(Request $request){
        $lic = $_POST['form']['licNum'];
        $date = $_POST['form']['date'];
        $newdrivname = $_POST['form']['driv'];
        
        $driver = $this->getDoctrine()
                        ->getRepository('BuskoEntityBundle:Employees')
                        ->findOneBy(array('username' => $newdrivname));
        
        $newdrivid = $driver->getId();
        
        $product = $this->getDoctrine()
                        ->getRepository('BuskoEntityBundle:Drives')
                        ->findOneBy(array('date'=> $date,'licNum' => $lic));
        
        if($product->getDriv()->getId()->getId() == $newdrivid){
            $form = $this->createFormBuilder(new Drives())
                         ->add(
                            'driv',
                            'entity',array(
                            'label' => 'Driver',
                            'class' => 'BuskoEntityBundle:Drivers',
                            'property' => 'id',
                            ))
                        ->add('date','hidden',array('data' => $date))
                        ->add('licNum','hidden',array('data' => $lic))
                        ->add('save', 'submit')
                        ->setAction($this->generateUrl('reset_drives_driver'))
                        ->setMethod('POST')
                        ->getForm();
                return $this->render('BuskoJourneyBundle:HRAssignment:existingdriver.html.twig',array('form' => $form->createView()));
        }
        else{
            $driver = $this->getDoctrine()
                        ->getRepository('BuskoEntityBundle:Drivers')
                        ->findOneBy(array('id'=> $newdrivid));
            
            $product->setDriv($driver);
            $this->getDoctrine()->getEntityManager()->flush();
            
            return $this->render('BuskoJourneyBundle:HRAssignment:update.html.twig',array('driv' => $newdrivname,'ass' => $product->getAss()->getId(), 'date' =>$date, 'lic' => $lic));
            
        }
    }
    
    public function updateAssistantAction(Request $request){
        $date = $request->get('date');
        $lic = $request->get('lic');
        
        $form = $this->createFormBuilder(new Drives())
        ->add(
            'ass',
            'entity',array(
                'label' => 'Assistant',
                'class' => 'BuskoEntityBundle:Assistants',
                'property' => 'id',
            ))
        ->add('date','hidden',array('data' => $date))
        ->add('licNum','hidden',array('data' => $lic))
        ->add('save', 'submit')
        ->setAction($this->generateUrl('reset_drives_assistant'))
        ->setMethod('POST')
        ->getForm();
        return $this->render('BuskoJourneyBundle:HRAssignment:selectassistant.html.twig',array('form' => $form->createView()));
    }
    
    public function resetAssistantAction(Request $request){
        $lic = $_POST['form']['licNum'];
        $date = $_POST['form']['date'];
        $newassname = $_POST['form']['ass'];
        
        $assistant = $this->getDoctrine()
                        ->getRepository('BuskoEntityBundle:Employees')
                        ->findOneBy(array('username' => $newassname));
        $newassid = $assistant->getId();
        
        $product = $this->getDoctrine()
                        ->getRepository('BuskoEntityBundle:Drives')
                        ->findOneBy(array('date'=> $date,'licNum' => $lic));
        
        if($product->getAss()->getId()->getId() == $newassid){
            $form = $this->createFormBuilder(new Drives())
                         ->add(
                            'ass',
                            'entity',array(
                            'label' => 'Assistant',
                            'class' => 'BuskoEntityBundle:Assistants',
                            'property' => 'id',
                            ))
                        ->add('date','hidden',array('data' => $date))
                        ->add('licNum','hidden',array('data' => $lic))
                        ->add('save', 'submit')
                        ->setAction($this->generateUrl('reset_drives_assistant'))
                        ->setMethod('POST')
                        ->getForm();
                return $this->render('BuskoJourneyBundle:HRAssignment:existingassistant.html.twig',array('form' => $form->createView()));
        }
        else{
            $assistant = $this->getDoctrine()
                        ->getRepository('BuskoEntityBundle:Assistants')
                        ->findOneBy(array('id'=> $newassid));
            
            $product->setAss($assistant);
            $this->getDoctrine()->getEntityManager()->flush();
            
            return $this->render('BuskoJourneyBundle:HRAssignment:update.html.twig',array('driv' => $product->getDriv()->getId(),'ass' => $newassname, 'date' =>$date, 'lic' => $lic));
            
        }
    }
    
    public function displayAssignmentAction(){
        $drives = $this->getDoctrine()->getEntityManager()
                                  ->getRepository('BuskoEntityBundle:Drives')
                                  ->findAll();
        
        for($i =0; $i <count($drives);$i++){
            $realdate = new DateTime();
            $realdate->setTimeStamp($drives[$i]->getDate());
            $stringdate = $realdate->format("Y M d");
            $drives[$i]->setDate($stringdate);
        }
        return $this->render('BuskoJourneyBundle:Display:displaydrivesinfo.html.twig',array('drives'=>$drives)); 
    }
}
?>
