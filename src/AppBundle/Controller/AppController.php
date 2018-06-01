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

    {    if ($this->get('security.authorization_checker')->isGranted('ROLE_DELEGUE')) 
              return $this->redirectToRoute('abonnement_index');
        elseif ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) 
              return $this->redirectToRoute('user_index');
        elseif ($this->get('security.authorization_checker')->isGranted('ROLE_CONTROLEUR')) 
              return $this->redirectToRoute('concours_index');
          elseif ($this->get('security.authorization_checker')->isGranted('ROLE_SUPERVISEUR'))
              return $this->redirectToRoute('session_index');              
         elseif($this->get('security.authorization_checker')->isGranted('ROLE_SAISIE')) 
              return $this->redirectToRoute('partie_index');
        elseif ($this->get('security.authorization_checker')->isGranted('ROLE_MESSAGER'))
              return $this->redirectToRoute('notification_index');  
        return $this->redirectToRoute('notification_index');             
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