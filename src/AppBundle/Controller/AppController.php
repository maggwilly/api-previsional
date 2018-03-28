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
    {     if ($this->get('security.context')->isGranted('ROLE_ADMIN')) 
                return $this->redirectToRoute('abonnement_index');
         elseif ($this->get('security.context')->isGranted('ROLE_SAISIE')) {
                return $this->redirectToRoute('partie_index', array('id' => 0));
          }elseif ($this->get('security.context')->isGranted('ROLE_MESSAGER'))
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