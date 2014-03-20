<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Busko\JourneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Busko\JourneyBundle\Forms\TimetableType;

class TimetableIndexController extends Controller {

    public function TimetableAction(Request $request) {



        $StartBusStop = $_POST['Busko']['StartBusStop'];
        $StopBusStop = $_POST['Busko']['StopBusStop'];
        $date = $_POST['Busko']['date'];
        $from = $_POST['Busko']['from']['hour'];
        $to = $_POST['Busko']['to']['hour'];

        //Checks whether the user has  selected different bus stops
        if ($StartBusStop == $StopBusStop) {
            $form = $this->createForm(new TimetableType(), null, array(
                'action' => $this->generateUrl('busko_journey_Timetablehomepage'),
                'attr' => array(
                    'class' => 'form-horizontal',))
            );
            $errorMsg = 'Select different bus stops';
            $sErrorMsg = '';
            return $this->render('BuskoJourneyBundle:Home:HomeError.html.twig', array('form' => $form->createView(), 'errorMsg' => $errorMsg));
        }

        //Checks whether the user has selected a valid time interval
        if ($from >= $to) {
            $form = $this->createForm(new TimetableType(), null, array(
                'action' => $this->generateUrl('busko_journey_Timetablehomepage'),
                'attr' => array(
                    'class' => 'form-horizontal',))
            );
            $errorMsg = 'Invalid time interval';
            return $this->render('BuskoJourneyBundle:Home:HomeError.html.twig', array('form' => $form->createView(), 'errorMsg' => $errorMsg));
        }

        //Checks whether there are direct bus routes between the given busstops
        $em = $this->getDoctrine()->getEntityManager();
        $intermediates = $em->getRepository('BuskoEntityBundle:Intermediates');
        $journeys = $em->getRepository('BuskoEntityBundle:Journeys');


        $query = $em->createQuery('SELECT t.routeId FROM  BuskoEntityBundle:Intermediates AS t, BuskoEntityBundle:Intermediates AS s
            WHERE t.routeId = s.routeId
            AND t.stopId = :id1
            AND s.stopId = :id2');

        $query->setParameter('id1', $StartBusStop);
        $query->setParameter('id2', $StopBusStop);

        $presentRoutes = $query->getResult();
        //echo json_encode($presentRoutes);

        if ($presentRoutes) {
            
        } else {
            //If there are no direct routes between these 
            $form = $this->createForm(new TimetableType(), null, array(
                'action' => $this->generateUrl('busko_journey_Timetablehomepage'),
                'attr' => array(
                    'class' => 'form-horizontal',))
            );
            $StartBusStop = $em->find('BuskoEntityBundle:BusStops', $StartBusStop)->getCity();
            $StopBusStop = $em->find('BuskoEntityBundle:BusStops', $StopBusStop)->getCity();

            $errorMsg = 'There are no direct buses between ' . $StartBusStop . ' and ' . $StopBusStop;
            return $this->render('BuskoJourneyBundle:Home:HomeError.html.twig', array('form' => $form->createView(), 'errorMsg' => $errorMsg));
        }
        
        foreach($presentRoutes as $route ){
            $route=$route['routeId'];
            echo $route;
            $query = $em->createQuery('SELECT stationNumber FROM  BuskoEntityBundle:Intermediates 
                WHERE routeId = :rid
                AND stopId = :startid
               ');
            $startStationNumber= $query->getSingleResult();
            
            
        }
        
        




        //$form = $this->createForm(new TimetableType());
        //$form->handleRequest($request);
        //echo $form["StopBusStop"]->getData();
        //$TimetableRequest = $form->getData();
        //echo $request->get('Busko[StartBusStop]');
        //echo $TimetableRequest->getstartBusStop();

        /*
          $em = $this->getDoctrine()->getEntityManager();
          $form = $this->createForm(new TimetableType());

          $form->handleRequest($request);


          if ($form->isValid()) {


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
         */
        /* return $this->render(
          'VolunteerManagementSystemProjectBundle:Error:error.html.twig',
          array('form' => $form->createView(),'id'=>$id)
          ); */
    }

}
