<?php

namespace Busko\StyleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StyleController extends Controller
{
    public function basicAction()
    {
        return $this->render('BuskoStyleBundle:Home:basic.html.twig');
    }
}
