<?php

namespace Busko\EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        return $this->render('BuskoEmployeeBundle:Security:login.html.twig');
    }
}
