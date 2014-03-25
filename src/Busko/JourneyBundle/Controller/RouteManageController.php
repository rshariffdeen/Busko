<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Busko\EntityBundle\Entity\Routes;
use Busko\EntityBundle\Entity\Buses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RouteManageController extends Controller{
    
    public function selectRouteAction(Request $request){
        $form = $this->createFormBuilder(new Routes())
        ->add(
            'routeId',
            'entity',array(
                'label' => 'Route ID',
                'class' => 'BuskoEntityBundle:Routes',
                'property' => 'route_id',
                'query_builder' => function(EntityRepository $er) {
                                    return $er->createQueryBuilder('p')
                                              ->orderBy('p.routeId', 'ASC');
                                   }
            ))
        ->add('select', 'submit')
        ->setAction($this->generateUrl('busko_journey_selectbus'))
        ->setMethod('POST')
        ->getForm();
            
        return $this->render('BuskoJourneyBundle:Route:selectroute.html.twig',array('form' => $form->createView()));
    }
    
    public function selectBusAction(Request $request){
        $route = $_POST['form']['routeId'];
        $form = $this->createFormBuilder(new Buses())
        ->add(
            'licNum',
            'entity',array(
                'label' => 'Bus ID',
                'class' => 'BuskoEntityBundle:Buses',
                'property' => 'lic_num',
                'query_builder' => function(EntityRepository $er) {
                                    return $er->createQueryBuilder('p')
                                              ->orderBy('p.licNum', 'ASC');
                                   }
            ))
        ->add('route','hidden',array('data' => $route))
        ->add('select', 'submit')
        ->setAction($this->generateUrl('busko_journey_submitbus'))
        ->setMethod('POST')
        ->getForm();
            
        return $this->render('BuskoJourneyBundle:Route:selectbus.html.twig',array('form' => $form->createView()));
    }
    
    public function submitBusAction(Request $request){
        $routeid = $_POST['form']['route'];
        $licnum = $_POST['form']['licNum'];
        
        $bus = $this->getDoctrine()
                        ->getRepository('BuskoEntityBundle:Buses')
                        ->findOneBy(array('route'=> $routeid,'licNum' => $licnum));
        
        $form = $this->createFormBuilder(new Buses())
        ->add(
            'licNum',
            'entity',array(
                'label' => 'Bus ID',
                'class' => 'BuskoEntityBundle:Buses',
                'property' => 'lic_num',
                'query_builder' => function(EntityRepository $er) {
                                    return $er->createQueryBuilder('p')
                                              ->orderBy('p.licNum', 'ASC');
                                   }
            ))
        ->add('route','hidden',array('data' => $routeid))
        ->add('select', 'submit')
        ->setAction($this->generateUrl('busko_journey_submitbus'))
        ->setMethod('POST')
        ->getForm();
            
        if(!$bus){
            $route = $this->getDoctrine()
                        ->getRepository('BuskoEntityBundle:Routes')
                        ->findOneBy(array('routeId'=> $routeid));
            $bus1 = $this->getDoctrine()
                        ->getRepository('BuskoEntityBundle:Buses')
                        ->findOneBy(array('licNum' => $licnum));
            
            $bus1->setRoute($route);
            $this->getDoctrine()->getEntityManager()->flush();
            
            return $this->render('BuskoJourneyBundle:Route:selectbus.html.twig',array('form' => $form->createView()));
        }
        else{
           return $this->render('BuskoJourneyBundle:Route:existingbus.html.twig',array('form'=>$form->createView())); 
            
        }
    }
    
    public function displayBusAction(){
        $buses = $this->getDoctrine()->getEntityManager()
                                  ->getRepository('BuskoEntityBundle:Buses')
                                  ->findAll();
        
        return $this->render('BuskoJourneyBundle:Display:displaybusinfo.html.twig',array('buses'=>$buses)); 
    }
}
?>
