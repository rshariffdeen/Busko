<?php

namespace Busko\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller {

    public function indexAction() {
        if ($this->getUser() == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }







        return $this->render('BuskoSiteBundle:Admin:home.html.twig');
    }

    public function routeAction() {
        if ($this->getUser() == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }
        return $this->render('BuskoSiteBundle:Admin:routes.html.twig');
    }

    public function empAction() {
        if ($this->getUser() == null) {
            return $this->forward('FOSUserBundle:Security:login');
        } else {
            $em = $this->getDoctrine()->getManager();
            $employees = $em->getRepository('BuskoEntityBundle:Employees')->findAll();

            $drivers = $em->createQuery(
                                    'SELECT * FROM BuskoEntityBundle:Employees JOIN BuskoEntityBundle:Drivers'       
                            );

            try {
                return $drivers->getSingleResult();
            } catch (\Doctrine\ORM\NoResultException $e) {
                return null;
            }

            $admins = $em->getRepository('BuskoEntityBundle:Administrators')->findAll();
            $operators = $em->getRepository('BuskoEntityBundle:Operators')->findAll();
            $assistants = $em->getRepository('BuskoEntityBundle:Assistants')->findAll();
            return $this->render('BuskoSiteBundle:Admin:employees.html.twig', array('employees' => $employees, 'drivers' => $drivers, 'assistants' => $assistants, 'admins' => $admins, 'operators' => $operators));
        }
    }

    public function branchAction() {
        if ($this->getUser() == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }
        return $this->render('BuskoSiteBundle:Admin:branches.html.twig');
    }

    public function busAction() {
        if ($this->getUser() == null) {
            return $this->forward('FOSUserBundle:Security:login');
        }
        return $this->render('BuskoSiteBundle:Admin:buses.html.twig');
    }

}
