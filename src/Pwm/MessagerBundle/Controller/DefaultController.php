<?php

namespace Pwm\MessagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MessagerBundle:Default:index.html.twig');
    }
}
