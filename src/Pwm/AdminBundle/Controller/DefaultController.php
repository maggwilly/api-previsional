<?php

namespace Pwm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	
       return $this->redirectToRoute('abonnement_index');
    }
}
