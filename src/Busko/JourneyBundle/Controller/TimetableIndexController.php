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

        $numberOfRoutes = count($presentRoutes); //Number of routes between the given bus stops
        $resultArray; // Contains the results of the final schedule

        echo $numberOfRoutes;
        //For each present route in the given destination and source generates the schedules as follows
        for ($x = 0; $x < $numberOfRoutes; $x++) {

            $route = $presentRoutes[$x]['routeId'];
            echo $route;
            //Get the station number of the StartBusStop
            $query = $em->createQuery('SELECT t.stationNumber FROM BuskoEntityBundle:Intermediates AS t
                WHERE t.routeId =:rid
                AND t.stopId =:startid'
            );
            $query->setParameter('startid', $StartBusStop);
            $query->setParameter('rid', $route);
            $startStationNumber = $query->getSingleResult();

            $startStationNumber = $startStationNumber['stationNumber'];
            echo 'start:' . $startStationNumber;

            //Get the station number of the StopBusStop
            $query = $em->createQuery('SELECT t.stationNumber FROM BuskoEntityBundle:Intermediates AS t
                WHERE t.routeId =:rid
                AND t.stopId =:stopid'
            );
            $query->setParameter('stopid', $StopBusStop);
            $query->setParameter('rid', $route);
            $stopStationNumber = $query->getSingleResult();

            $stopStationNumber = $stopStationNumber['stationNumber'];
            echo 'stop:' . $stopStationNumber;


            //Calculates the time between the given bus stops in the considering route
            $query = $em->createQuery('SELECT SUM(t.duration) FROM BuskoEntityBundle:Intermediates AS t
                WHERE t.routeId =:rid
                AND t.stationNumber >:startstationnumber
                AND t.stationNumber <=:stopstationnumber'
            );
            if ($startStationNumber > $stopStationNumber) {
                $query->setParameter('stopstationnumber', $startStationNumber);
                $query->setParameter('startstationnumber', $stopStationNumber);
            } else {
                $query->setParameter('stopstationnumber', $stopStationNumber);
                $query->setParameter('startstationnumber', $startStationNumber);
            }
            $query->setParameter('rid', $route);
            $duration = $query->getResult(); //----------------------------------------------------------------------------
            //Calculates the time from departure of the bus from the base bus stop in the considering route and the 

            if ($startStationNumber < $stopStationNumber) {

                $stmt = $this->getDoctrine()->getEntityManager()
                        ->getConnection()
                        ->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) FROM intermediates 
                WHERE route_id =:rid
                AND station_number >:startstationid');
                $stmt->bindValue('rid',  0);
                $stmt->bindValue('startstationid', $startStationNumber);
               
                $stmt->execute();
                $result = $stmt->fetchAll();
                echo json_encode($result);
                /*
                $query = $em->createQuery('SELECTSUM(t.duration) FROM BuskoEntityBundle:Intermediates AS t
                WHERE t.routeId =:rid
                AND t.stationNumber >:routestartid
                AND t.stationNumber <=:startstationid'
                );
                $query->setParameter('routestartid', 0);
                $query->setParameter('startstationid', $startStationNumber);*/
            } else {
                $query = $em->createQuery('SELECT SUM(t.duration ) FROM BuskoEntityBundle:Intermediates AS t
                WHERE t.routeId =:rid
                AND t.stationNumber >:startstationid'
                );
                $query->setParameter('startstationid', $startStationNumber);
            }
            $query->setParameter('rid', $route);
            echo $durationToStartBusStop = $query->getResult(); //----------------------------------------------------------------------------
            //Get all the departure time of the considering route for the given date

            $query = $em->createQuery('SELECT t.startTime FROM BuskoEntityBundle:Journeys AS t
                WHERE t.route =:rid
                AND t.date =:date'
            );

            $query->setParameter('date', $date);
            $query->setParameter('rid', $route);
            $departureTime = $query->getResult();
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
