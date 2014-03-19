<?php

namespace Busko\JourneyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Busko\EntityBundle\Entity\Routes;
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
        ->setAction($this->generateUrl('reset_drives_driver'))
        ->setMethod('POST')
        ->getForm();
            
        return $this->render('BuskoJourneyBundle:Route:selectroute.html.twig',array('form' => $form->createView()));
    }
    
    
}
?>
