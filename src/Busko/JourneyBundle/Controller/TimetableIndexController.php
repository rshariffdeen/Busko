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
            $form->handleRequest($request);
            $errorMsg = 'Select different bus stops';

            return $this->render('BuskoJourneyBundle:Home:HomeError.html.twig', array('form' => $form->createView(), 'errorMsg' => $errorMsg));
        }

        //Checks whether the user has selected a valid time interval
        if ($from >= $to) {
            $form = $this->createForm(new TimetableType(), null, array(
                'action' => $this->generateUrl('busko_journey_Timetablehomepage'),
                'attr' => array(
                    'class' => 'form-horizontal',))
            );
            $form->handleRequest($request);
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
            $form->handleRequest($request);
            $StartBusStop = $em->find('BuskoEntityBundle:BusStops', $StartBusStop)->getCity();
            $StopBusStop = $em->find('BuskoEntityBundle:BusStops', $StopBusStop)->getCity();

            $errorMsg = 'There are no direct buses between ' . $StartBusStop . ' and ' . $StopBusStop;
            return $this->render('BuskoJourneyBundle:Home:HomeError.html.twig', array('form' => $form->createView(), 'errorMsg' => $errorMsg));
        }

        $numberOfRoutes = count($presentRoutes); //Number of routes between the given bus stops
        $resultArray = array(); // Contains the results of the final schedule-----------------------------------------------------------------------------------------------------------------
        //For each present route in the given destination and source generates the schedules as follows
        for ($x = 0; $x < $numberOfRoutes; $x++) {

            $route = $presentRoutes[$x]['routeId'];
            //echo $route;
            //Get the station number of the StartBusStop
            $query = $em->createQuery('SELECT t.stationNumber FROM BuskoEntityBundle:Intermediates AS t
                WHERE t.routeId =:rid
                AND t.stopId =:startid'
            );
            $query->setParameter('startid', $StartBusStop);
            $query->setParameter('rid', $route);
            $startStationNumber = $query->getSingleResult();

            $startStationNumber = $startStationNumber['stationNumber'];
            //echo json_encode($startStationNumber);
            //Get the station number of the StopBusStop
            $query = $em->createQuery('SELECT t.stationNumber FROM BuskoEntityBundle:Intermediates AS t
                WHERE t.routeId =:rid
                AND t.stopId =:stopid'
            );
            $query->setParameter('stopid', $StopBusStop);
            $query->setParameter('rid', $route);
            $stopStationNumber = $query->getSingleResult();

            $stopStationNumber = $stopStationNumber['stationNumber'];
            //echo 'stop:' . $stopStationNumber;
            //Calculates the time between the given bus stops in the considering route


            $stmt = $this->getDoctrine()->getEntityManager()
                    ->getConnection()
                    ->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) AS duration FROM intermediates 
                WHERE route_id = :rid
                AND station_number > :startstationid
                AND station_number <= :stopstationid
                ');
            $stmt->bindValue('rid', $route);
            if ($startStationNumber < $stopStationNumber) {
                $stmt->bindValue('startstationid', $startStationNumber);
                $stmt->bindValue('stopstationid', $stopStationNumber);
            } else {
                $stmt->bindValue('startstationid', $stopStationNumber);
                $stmt->bindValue('stopstationid', $startStationNumber);
            }
            $stmt->execute();
            /*
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
              $query->setParameter('rid', $route)
              $duration = $query->getResult();
             * //----------------------------------------------------------------------------
             */
            $duration = $stmt->fetchAll();
            $duration = $duration[0]['duration'];
            //Calculates the time from departure of the bus from the base bus stop in the considering route and the direction 
            $durationToStartBusStop = NULL; //------------------------------------------------------------------------------------------------
            if ($startStationNumber < $stopStationNumber) {

                $stmt = $this->getDoctrine()->getEntityManager()
                        ->getConnection()
                        ->prepare('SELECT duration AS duration FROM intermediates 
                WHERE route_id =:rid
                AND station_number <=:startstationid');
                $stmt->bindValue('rid', $route);
                $stmt->bindValue('startstationid', $startStationNumber);

                $stmt->execute();
                $durationToStartBusStop = $stmt->fetchAll();

                //$test=new \DateInterval('PT40M');

                $durationToStartBusStop = $durationToStartBusStop[0]['duration'];
            } else {
                $stmt = $this->getDoctrine()->getEntityManager()
                        ->getConnection()
                        ->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duration))) AS duration FROM intermediates 
                WHERE route_id =:rid
                AND station_number >:startstationid');
                $stmt->bindValue('rid', $route);
                $stmt->bindValue('startstationid', $startStationNumber);

                $stmt->execute();
                $durationToStartBusStop = $stmt->fetchAll();
                $durationToStartBusStop = $durationToStartBusStop[0]['duration'];
            }
            //echo $durationToStartBusStop;
            //Get the startingBusStop's ID of the considered route
            $query = $em->createQuery('SELECT IDENTITY(t.stopId) FROM BuskoEntityBundle:Intermediates AS t
                WHERE t.routeId =:rid
                AND t.stationNumber=0'
            );

            $query->setParameter('rid', $route);

            $RouteStartBusStopId = $query->getResult();
            //echo 'RouteStart: ' . ($RouteStartBusStopId[0][1]);
            //Get all the departure time of the considering route for the given date and the direction

            $RDate = new \DateTime();
            $RDate->setTimeStamp(strtotime($date));
            $formattedDate = $RDate->format("Y-m-d");

            if ($startStationNumber < $stopStationNumber) {
                $query = $em->createQuery('SELECT t.startTime AS startTime, IDENTITY (t.licNum) as busNo FROM BuskoEntityBundle:Journeys AS t
                WHERE t.route =:rid
                AND t.date LIKE :date
                AND t.startStop=:routeStart'
                );
            } else {
                $query = $em->createQuery('SELECT t.startTime AS startTime, t.licNum as busNo FROM BuskoEntityBundle:Journeys AS t
                WHERE t.route =:rid
                AND t.date =:date
                AND t.startStop<>:routeStart'
                );
            }

            $query->setParameter('routeStart', $RouteStartBusStopId[0][1]);
            $query->setParameter('date', $RDate);
            $query->setParameter('rid', $route);
            $departureTimes = $query->getResult(); //---------------------------------------------------------------------------------------
            // echo json_encode($departureTimes);


            foreach ($departureTimes as $departureTime) {
                $busNo = $departureTime['busNo'];

                $departureTime = $departureTime['startTime'];
                
                $tempArray1 = explode(":", $durationToStartBusStop);
                $formatted1 = 'PT' . $tempArray1[0] . 'H' . $tempArray1[1] . 'M';
                $tempInterval1 = new \DateInterval($formatted1);
                echo 'toStart' . json_encode($tempInterval1);
                $timeToStartBusStop = $departureTime->add($tempInterval1);
                echo 'final '.json_encode($timeToStartBusStop);

                $timeToStartBusStoptemp=new \DateTime($timeToStartBusStop->format('H:i'));
                $tempArray = explode(":", $duration);
                $formatted = 'PT' . $tempArray[0] . 'H' . $tempArray[1] . 'M';
                $tempInterval = new \DateInterval($formatted);
                echo 'duration' . json_encode($tempInterval);
                $timeToStopBusStop = $timeToStartBusStoptemp->add($tempInterval);

                $timeToStartBusStop = $timeToStartBusStop->format("H:i");
                $timeToStopBusStop = $timeToStopBusStop->format("H:i");
                //$timeToStartBusStop = strtotime($departureTime) + strtotime($durationToStartBusStop);
                //$timeToStopBusStop = strtotime($timeToStartBusStop) + strtotime($duration);

                if ((strtotime($timeToStartBusStop) >= strtotime($to)) || (strtotime($timeToStartBusStop) <= strtotime($from))) {
                    array_push($resultArray, array('busNo' => $busNo, 'route' => $route, 'startTime' => $timeToStartBusStop, 'stopTime' => $timeToStopBusStop));
                }
            }
        }

        if (count($resultArray)==0) {
            $form = $this->createForm(new TimetableType(), null, array(
                'action' => $this->generateUrl('busko_journey_Timetablehomepage'),
                'attr' => array(
                    'class' => 'form-horizontal',))
            );
            $errorMsg = 'There are no busses in the given time interval. Select a different time interval ';

            $form->handleRequest($request);
            return $this->render('BuskoJourneyBundle:Home:HomeError.html.twig', array('form' => $form->createView(), 'errorMsg' => $errorMsg));
        }

        $form = $this->createForm(new TimetableType(), null, array(
            'action' => $this->generateUrl('busko_journey_Timetablehomepage'),
            'attr' => array(
                'class' => 'form-horizontal',))
        );


        $form->handleRequest($request);
        $StartBusStop = $em->find('BuskoEntityBundle:BusStops', $StartBusStop)->getCity();
        $StopBusStop = $em->find('BuskoEntityBundle:BusStops', $StopBusStop)->getCity();
        return $this->render('BuskoJourneyBundle:Home:HomeResult.html.twig', array('form' => $form->createView(), 'results' => $resultArray, 'start' => $StartBusStop, 'stop' => $StopBusStop, 'number' => count($resultArray),));
    }

}
