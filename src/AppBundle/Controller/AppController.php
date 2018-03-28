<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Etape controller.
 *
 */
class AppController extends Controller
{
    /**
     * Lists all etape entities.
     *
     */
    public function indexAction()

    {   
   switch ($this->getUser()) {
    case 'SAISIE':
        # code...
        return $this->redirectToRoute('partie_index', array('id' => 0));
    case 'COMM':
         return $this->redirectToRoute('notification_index');     
    default:
        # code...
         return $this->redirectToRoute('notification_index');   
}
          
    }



    public function helpAction($topic)
    {      
    return $this->render('reads/help.html.twig', array());
    }

    public function cguAction()
    {      
    return $this->render('reads/cgu.html.twig', array());
    }
}